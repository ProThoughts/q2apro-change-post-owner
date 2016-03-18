=========================================
Question2Answer Plugin: Change Post Owner
=========================================
-----------
Description
-----------
This is a plugin_ for Question2Answer_ that changes the owner of a post or makes the post anonymous.

------------
Installation
------------
#. Install Question2Answer_ if you haven't already.
#. Get the source code for this plugin directly from github_ or from the `q2apro plugin page`_.
#. Extract the files.
#. Optional: Add your language strings in copying file ``q2apro-post-owner-lang-default.php`` to e. g. ``q2apro-post-owner-lang-fr.php``
#. Upload the files to a subfolder called ``q2apro-change-post-owner`` inside the ``qa-plugin`` folder of your Q2A installation.
#. Navigate to your site, go to **Admin -> Plugins**. Check if the plugin "q2apro Change Post Owner" is listed.
#. Navigate to ``yourq2asite.com/postowner``. This site is only accessible by the admin.

----------
How-To-Use
----------
1. Get question link or post id.
2. Insert it into the input field on page ``yourq2asite.com/postowner``
3. Insert the name of the new owner (exact username) or click ``make post anonymous``.
4. Click the submit button, done!

----------
Disclaimer
----------
This is **beta** code. It is probably okay for production environments, but may not work exactly as expected. You bear the risk. Refunds will not be given!

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
See the GNU General Public License for more details.

---------
Copyright
---------
All code herein is OpenSource_. Feel free to build upon it and share with the world.

---------
About q2a
---------
Question2Answer_ is a free and open source PHP software for Q&A sites.

----------
Final Note
----------
If you use the plugin:
  * Consider joining the `Question2Answer forum`_, answer some questions or write your own plugin!
  * You can use the code of this plugin to learn more about q2a-plugins. It is commented code.
  * Visit q2apro.com_ to get more free and premium plugins_.

  
.. _github: https://github.com/q2apro/q2apro-change-post-owner
.. _OpenSource: http://www.gnu.org/licenses/gpl.html
.. _q2apro plugin page: http://www.q2apro.com/plugins/change-post-owner
.. _q2apro.com: http://www.q2apro.com
.. _plugin: http://www.q2apro.com/plugins
.. _plugins: http://www.q2apro.com/plugins
.. _Question2Answer: http://www.question2answer.org/
.. _Question2Answer forum: http://www.question2answer.org/qa/
