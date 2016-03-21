<?php

/*
	Plugin Name: Change Post Owner
	Plugin Author: q2apro.com
*/

	class q2apro_post_owner_page
	{
		
		var $directory;
		var $urltoroot;
		
		function load_module($directory, $urltoroot)
		{
			$this->directory=$directory;
			$this->urltoroot=$urltoroot;
		}
		
		// for display in admin interface under admin/pages
		function suggest_requests() 
		{	
			return array(
				array(
					'title' => 'Change Owner of Post', // title of page
					'request' => 'postowner', // request name
					'nav' => 'M', // 'M'=main, 'F'=footer, 'B'=before main, 'O'=opposite main, null=none
				),
			);
		}
		
		// for url query
		function match_request($request)
		{
			if ($request=='postowner')
			{
				return true;
			}

			return false;
		}

		function process_request($request)
		{
		
			// return if not admin level
			$level=qa_get_logged_in_level();
			if($level<QA_USER_LEVEL_ADMIN)
			{
				$qa_content = qa_content_prepare();
				$qa_content['error'] = qa_lang('q2apro_post_owner_lang/not_allowed');
				return $qa_content;
			}

			// start content
			$qa_content = qa_content_prepare();

			// page title
			$qa_content['title'] = qa_lang('q2apro_post_owner_lang/page_title'); 

			// init 
			$qa_content['custom'] = '';

			// some CSS styling
			$qa_content['custom'] .= '
			<style type="text/css">
				#convdiv, .qa-main p, .qa-main a, .qa-main input { 
					font-size:14px; padding:2px 5px;
				}
				#convdiv {
					border-left:10px solid #ABF;margin:20px 0 0 5px;padding:5px 10px;
				}
				.qa-main h1 {
					margin-bottom:40px;
				}
				.qa-main input {
					border:1px solid #CCC;
					padding:5px;
				}
			</style>
			';
			
			
			// REQUEST: if we have convert data, convert
			$postid = qa_post_text('postid');
			$newusername = qa_post_text('newusername');
			$makeanonym = qa_post_text('makeanonym'); // checkbox
			
			if(isset($postid))
			{
				if(filter_var($postid, FILTER_VALIDATE_URL))
				{
					$parts = preg_split('|[=/&]|', $postid, -1, PREG_SPLIT_NO_EMPTY);
					$keypostids=array();

					foreach ($parts as $part)
					{
						if (preg_match('/^[0-9]+$/', $part))
						{
							$keypostids[$part] = true;							
						}
					}
					
					require_once QA_INCLUDE_DIR.'qa-db-post-update.php';
					$questionids = qa_db_posts_filter_q_postids(array_keys($keypostids));

					if(count($questionids)==1)
					{
						$postid = $questionids[0];
					}
					else
					{
						$qa_content = qa_content_prepare();
						$qa_content['error'] = qa_lang('q2apro_post_owner_lang/not_found');
						return $qa_content;
					}
				}

				if(isset($newusername) && $newusername!='')
				{
					// get userid from newusername
					$newuserid = qa_handle_to_userid($newusername);
					if(!isset($newuserid))
					{
						// username does not exist
						$qa_content['custom'] .= '<p>'.qa_lang('q2apro_post_owner_lang/error1').'</p>';
						$qa_content['custom'] .= '<a href="'.qa_path('postowner').'" class="qa-form-basic-button">'.qa_lang('q2apro_post_owner_lang/return').'</a>';
						return $qa_content;
					}
				}
				else if(isset($makeanonym) && $makeanonym!='')
				{
					$newuserid = null;
				}
				else
				{
					// username does not exist, no anonym flag set
					$qa_content['custom'] .= '<p>'.qa_lang('q2apro_post_owner_lang/error2').'</p>';
					$qa_content['custom'] .= '<a href="'.qa_path('postowner').'" class="qa-form-basic-button">'.qa_lang('q2apro_post_owner_lang/return').'</a>';
					return $qa_content;
				}
			
				// assign new userid
				$convertQuery = qa_db_query_sub('UPDATE `^posts` 
												SET `userid` = # 
												WHERE `postid` = #
												LIMIT 1', $newuserid, $postid);

				// check if post is question, answer or comment
				$posttype = qa_db_read_one_value( 
									qa_db_query_sub('SELECT type FROM `^posts` 
														WHERE `postid` = # 
														LIMIT 1', $postid) );

				// questionid or answerid that will hold all succeeding comments to be transferred
				if($posttype=='Q')
				{
					// question
					$questionid = $postid; // e.g. 52838
					$succId = $questionid;
				}
				else if($posttype=='A')
				{
					// answer, we need to query again to receive the question id
					$answerid = $postid;
					$getQ_query = qa_db_read_all_assoc( 
										qa_db_query_sub('SELECT parentid FROM `^posts` 
															WHERE `postid` = # 
															AND `type` = "A"
															LIMIT 1', $answerid) );
					$questionid = $getQ_query[0]['parentid']; // e.g. 52838
				}
			
				// content output success, for now link Q
				$qa_content['custom'] .= '
										<p>'.
											qa_lang('q2apro_post_owner_lang/success').
										'</p>
										<a target="_blank" href="'.qa_path('').$questionid.'" class="qa-form-basic-button">'.qa_lang('q2apro_post_owner_lang/open_post').'</a>
										<a href="'.qa_path('postowner').'" class="qa-form-basic-button">'.qa_lang('q2apro_post_owner_lang/return').'</a>';
				return $qa_content;
			}


			/* default page with convert dialog */
			$qa_content['custom'] .= '<div id="convdiv">
											<form name="uploadform" method="post" action="'.qa_self_html().'">
												<input name="postid" id="postid" type="text" placeholder="'.qa_lang('q2apro_post_owner_lang/input_placeholder1').'" autofocus><br />
												<br />
												<input name="newusername" id="newusername" type="text" placeholder="'.qa_lang('q2apro_post_owner_lang/input_placeholder2').'" autofocus><br />
												<br />
												<input name="makeanonym" id="makeanonym" type="checkbox"> 
												<label for="makeanonym">'.qa_lang('q2apro_post_owner_lang/make_anonym').'</label><br />
												<br />
												<input type="submit" value="'.qa_lang('q2apro_post_owner_lang/convertbtn').'" class="qa-form-basic-button">
											</form>
										 </div>';
			return $qa_content;
		}
		
	};
	

/*
	Omit PHP closing tag to help avoid accidental output
*/