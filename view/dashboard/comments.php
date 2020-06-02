  <?php require "$_SERVER[DOCUMENT_ROOT]/public/admin/layout/head.html";?>
  <link rel="stylesheet" href="/public/admin/dist/css/comments.min.css" type="text/css" />
<body class="wp-admin wp-core-ui no-js legacy-color-fresh edit-comments-php auto-fold admin-bar branch-5-4 version-5-4-1 admin-color-fresh locale-en multisite no-customize-support no-svg">
<?php require "$_SERVER[DOCUMENT_ROOT]/public/admin/layout/top-nav.html";?>
<?php require "$_SERVER[DOCUMENT_ROOT]/public/admin/layout/sidebar-menu.html"; ?>
  <div id="wpcontent">
    <div class="wpcom-bubble action-bubble">
      <div class="bubble-txt"></div>
    </div>

    <div id="wpbody" role="main">

      <div id="wpbody-content">
        <div id="screen-meta" class="metabox-prefs">
          <div id="screen-options-wrap" class="hidden" tabindex="-1" aria-label="Screen Options Tab">
            <form id='adv-settings' method='post'>
              <fieldset class="metabox-prefs">
                <legend>Columns</legend>
                <label><input class="hide-column-tog" name="author-hide" type="checkbox" id="author-hide" value="author" checked='checked' />Author</label>
                <label><input class="hide-column-tog" name="response-hide" type="checkbox" id="response-hide" value="response" checked='checked' />In Response To</label>
                <label><input class="hide-column-tog" name="date-hide" type="checkbox" id="date-hide" value="date" checked='checked' />Submitted On</label>
                <label><input class="hide-column-tog" name="comment-likes-hide" type="checkbox" id="comment-likes-hide" value="comment-likes" checked='checked' /></label>
              </fieldset>
              <fieldset class="screen-options">
                <legend>Pagination</legend>
                <label for="edit_comments_per_page">Number of items per page:</label>
                <input type="number" step="1" min="1" max="999" class="screen-per-page" name="wp_screen_options[value]"
                       id="edit_comments_per_page" maxlength="3"
                       value="20" />
                <input type="hidden" name="wp_screen_options[option]" value="edit_comments_per_page" />
              </fieldset>

              <h5>Keyboard Shortcuts</h5>
              <div id="personal-comment-settings" class="metabox-prefs custom-options-panel requires-autosave"><input type="hidden" name="_wpnonce-personal-comment-settings" value="b9483ef478" /><label for="personal_comment_settings-comment_shortcuts" style="line-height: 20px;">
                <input type="checkbox" name="personal_comment_settings-comment_shortcuts" id="personal_comment_settings-comment_shortcuts" />Use keyboard shortcuts for comment moderation.</label></div><p class="submit"><input type="submit" name="screen-options-apply" id="screen-options-apply" class="button button-primary" value="Apply"  /></p>
              <input type="hidden" id="screenoptionnonce" name="screenoptionnonce" value="fd2ce6926d" />
            </form>
          </div>		</div>
        <div id="screen-meta-links">
          <div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
            <button type="button" id="show-settings-link" class="button show-settings" aria-controls="screen-options-wrap" aria-expanded="false">Screen Options</button>
          </div>
          <div id="contextual-help-link-wrap" class="hide-if-no-js screen-meta-toggle">
            <button type="button" id="contextual-help-link" class="button show-settings" aria-controls="contextual-help-wrap" aria-expanded="false">Help</button>
          </div>
        </div>

        <div class="wrap">
          <h1 class="wp-heading-inline">
            Comments</h1>


          <hr class="wp-header-end">


          <h2 class='screen-reader-text'>Filter comments list</h2><ul class='subsubsub'>
          <li class='all'><a href='https://ginger9353.wordpress.com/wp-admin/edit-comments.php?comment_status=all' class="current" aria-current="page">All <span class="count">(<span class="all-count">0</span>)</span></a> |</li>
          <li class='mine'><a href='https://ginger9353.wordpress.com/wp-admin/edit-comments.php?comment_status=mine&user_id=108542010'>Mine <span class="count">(<span class="mine-count">0</span>)</span></a> |</li>
          <li class='moderated'><a href='https://ginger9353.wordpress.com/wp-admin/edit-comments.php?comment_status=moderated'>Pending <span class="count">(<span class="pending-count">0</span>)</span></a> |</li>
          <li class='approved'><a href='https://ginger9353.wordpress.com/wp-admin/edit-comments.php?comment_status=approved'>Approved <span class="count">(<span class="approved-count">0</span>)</span></a> |</li>
          <li class='spam'><a href='https://ginger9353.wordpress.com/wp-admin/edit-comments.php?comment_status=spam'>Spam <span class="count">(<span class="spam-count">0</span>)</span></a> |</li>
          <li class='trash'><a href='https://ginger9353.wordpress.com/wp-admin/edit-comments.php?comment_status=trash'>Trash <span class="count">(<span class="trash-count">0</span>)</span></a></li>
        </ul>
          <form id="comments-form" method="get">


            <input type="hidden" name="comment_status" value="all" />
            <input type="hidden" name="pagegen_timestamp" value="2020-05-18 10:46:25" />

            <input type="hidden" name="_total" value="0" />
            <input type="hidden" name="_per_page" value="20" />
            <input type="hidden" name="_page" value="1" />


            <input type="hidden" id="_ajax_fetch_list_nonce" name="_ajax_fetch_list_nonce" value="775ab660ff" /><input type="hidden" name="_wp_http_referer" value="/wp-admin/edit-comments.php" /><input type="hidden" id="_wpnonce" name="_wpnonce" value="afbac5211b" /><input type="hidden" name="_wp_http_referer" value="/wp-admin/edit-comments.php" />	<div class="tablenav top">

            <div class="alignleft actions">
              <label class="screen-reader-text" for="filter-by-comment-type">Filter by comment type</label>
              <select id="filter-by-comment-type" name="comment_type">
                <option value="">All comment types</option>
                <option value="comment">Comments</option>
                <option value="pings">Pings</option>
              </select>
              <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filter"  /></div><div class="alignleft actions"><a
            class="button-secondary checkforspam button-disabled"
            href="https://ginger9353.wordpress.com/wp-admin/admin.php?action=akismet_recheck_queue"
            data-active-label="Checking for Spam"
            data-progress-label-format="(%1$s%)"
            data-success-url="/wp-admin/edit-comments.php?akismet_recheck_complete=1&amp;recheck_count=__recheck_count__&amp;spam_count=__spam_count__"
            data-failure-url="/wp-admin/edit-comments.php?akismet_recheck_error=1"
            data-pending-comment-count="0"
            data-nonce="c3916917df"
          ><span class="akismet-label">Check for Spam</span><span class="checkforspam-progress"></span></a><span class="checkforspam-spinner"></span></div><div class='tablenav-pages no-pages'><span class="displaying-num">0 items</span>
            <span class='pagination-links'><span class="tablenav-pages-navspan button disabled" aria-hidden="true">&laquo;</span>
<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&lsaquo;</span>
<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Current Page</label><input class='current-page' id='current-page-selector' type='text' name='paged' value='1' size='1' aria-describedby='table-paging' /><span class='tablenav-paging-text'> of <span class='total-pages'>0</span></span></span>
<a class='next-page button' href='https://ginger9353.wordpress.com/wp-admin/edit-comments.php?paged=0'><span class='screen-reader-text'>Next page</span><span aria-hidden='true'>&rsaquo;</span></a>
<a class='last-page button' href='https://ginger9353.wordpress.com/wp-admin/edit-comments.php?paged=0'><span class='screen-reader-text'>Last page</span><span aria-hidden='true'>&raquo;</span></a></span></div>
            <br class="clear" />
          </div>
            <h2 class='screen-reader-text'>Comments list</h2><table class="wp-list-table widefat fixed striped comments">
            <thead>
            <tr>
              <td  id='cb' class='manage-column column-cb check-column'><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox" /></td><th scope="col" id='author' class='manage-column column-author sortable desc'><a href="https://ginger9353.wordpress.com/wp-admin/edit-comments.php?orderby=comment_author&#038;order=asc"><span>Author</span><span class="sorting-indicator"></span></a></th><th scope="col" id='comment' class='manage-column column-comment column-primary'>Comment</th><th scope="col" id='response' class='manage-column column-response sortable desc'><a href="https://ginger9353.wordpress.com/wp-admin/edit-comments.php?orderby=comment_post_ID&#038;order=asc"><span>In Response To</span><span class="sorting-indicator"></span></a></th><th scope="col" id='date' class='manage-column column-date sortable desc'><a href="https://ginger9353.wordpress.com/wp-admin/edit-comments.php?orderby=comment_date&#038;order=asc"><span>Submitted On</span><span class="sorting-indicator"></span></a></th><th scope="col" id='comment-likes' class='manage-column column-comment-likes'><span class="vers"><img title="Comment Likes" alt="Comment Likes" src="//s0.wordpress.com/i/like-grey-icon.png" /></span></th>	</tr>
            </thead>

            <tbody id="the-comment-list" data-wp-lists="list:comment">
            <tr class="no-items"><td class="colspanchange" colspan="6">No comments found.</td></tr>	</tbody>

            <tbody id="the-extra-comment-list" data-wp-lists="list:comment" style="display: none;">
            <tr class="no-items"><td class="colspanchange" colspan="6">No comments found.</td></tr>	</tbody>

            <tfoot>
            <tr>
              <td   class='manage-column column-cb check-column'><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox" /></td><th scope="col"  class='manage-column column-author sortable desc'><a href="https://ginger9353.wordpress.com/wp-admin/edit-comments.php?orderby=comment_author&#038;order=asc"><span>Author</span><span class="sorting-indicator"></span></a></th><th scope="col"  class='manage-column column-comment column-primary'>Comment</th><th scope="col"  class='manage-column column-response sortable desc'><a href="https://ginger9353.wordpress.com/wp-admin/edit-comments.php?orderby=comment_post_ID&#038;order=asc"><span>In Response To</span><span class="sorting-indicator"></span></a></th><th scope="col"  class='manage-column column-date sortable desc'><a href="https://ginger9353.wordpress.com/wp-admin/edit-comments.php?orderby=comment_date&#038;order=asc"><span>Submitted On</span><span class="sorting-indicator"></span></a></th><th scope="col"  class='manage-column column-comment-likes'><span class="vers"><img title="Comment Likes" alt="Comment Likes" src="//s0.wordpress.com/i/like-grey-icon.png" /></span></th>	</tr>
            </tfoot>

          </table>
            <div class="tablenav bottom">

              <div class="alignleft actions">
              </div><div class="alignleft actions"><a
              class="button-secondary checkforspam button-disabled"
              href="https://ginger9353.wordpress.com/wp-admin/admin.php?action=akismet_recheck_queue"
              data-active-label="Checking for Spam"
              data-progress-label-format="(%1$s%)"
              data-success-url="/wp-admin/edit-comments.php?akismet_recheck_complete=1&amp;recheck_count=__recheck_count__&amp;spam_count=__spam_count__"
              data-failure-url="/wp-admin/edit-comments.php?akismet_recheck_error=1"
              data-pending-comment-count="0"
              data-nonce="c3916917df"
            ><span class="akismet-label">Check for Spam</span><span class="checkforspam-progress"></span></a><span class="checkforspam-spinner"></span></div><div class='tablenav-pages no-pages'><span class="displaying-num">0 items</span>
              <span class='pagination-links'><span class="tablenav-pages-navspan button disabled" aria-hidden="true">&laquo;</span>
<span class="tablenav-pages-navspan button disabled" aria-hidden="true">&lsaquo;</span>
<span class="screen-reader-text">Current Page</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">1 of <span class='total-pages'>0</span></span></span>
<a class='next-page button' href='https://ginger9353.wordpress.com/wp-admin/edit-comments.php?paged=0'><span class='screen-reader-text'>Next page</span><span aria-hidden='true'>&rsaquo;</span></a>
<a class='last-page button' href='https://ginger9353.wordpress.com/wp-admin/edit-comments.php?paged=0'><span class='screen-reader-text'>Last page</span><span aria-hidden='true'>&raquo;</span></a></span></div>
              <br class="clear" />
            </div>
          </form>
        </div>

        <div id="ajax-response"></div>

        <form method="get">
          <table style="display:none;"><tbody id="com-reply"><tr id="replyrow" class="inline-edit-row" style="display:none;"><td colspan="6" class="colspanchange">
            <fieldset class="comment-reply">
              <legend>
                <span class="hidden" id="editlegend">Edit Comment</span>
                <span class="hidden" id="replyhead">Reply to Comment</span>
                <span class="hidden" id="addhead">Add new Comment</span>
              </legend>

              <div id="replycontainer">
                <label for="replycontent" class="screen-reader-text">Comment</label>
                <div id="wp-replycontent-wrap" class="wp-core-ui wp-editor-wrap html-active"><link rel='stylesheet' id='all-css-0-2' href='https://s0.wp.com/wp-includes/css/editor.min.css?m=1575993379h&cssminify=yes' type='text/css' media='all' />
                  <div id="wp-replycontent-editor-container" class="wp-editor-container"><div id="qt_replycontent_toolbar" class="quicktags-toolbar"></div><textarea class="wp-editor-area" rows="20" cols="40" name="replycontent" id="replycontent"></textarea></div>
                </div>

              </div>

              <div id="edithead" style="display:none;">
                <div class="inside">
                  <label for="author-name">Name</label>
                  <input type="text" name="newcomment_author" size="50" value="" id="author-name" />
                </div>

                <div class="inside">
                  <label for="author-email">Email</label>
                  <input type="text" name="newcomment_author_email" size="50" value="" id="author-email" />
                </div>

                <div class="inside">
                  <label for="author-url">URL</label>
                  <input type="text" id="author-url" name="newcomment_author_url" class="code" size="103" value="" />
                </div>
              </div>

              <div id="replysubmit" class="submit">
                <p class="reply-submit-buttons">
                  <button type="button" class="save button button-primary">
                    <span id="addbtn" style="display: none;">Add Comment</span>
                    <span id="savebtn" style="display: none;">Update Comment</span>
                    <span id="replybtn" style="display: none;">Submit Reply</span>
                  </button>
                  <button type="button" class="cancel button">Cancel</button>
                  <span class="waiting spinner"></span>
                </p>
                <div class="notice notice-error notice-alt inline hidden">
                  <p class="error"></p>
                </div>
              </div>

              <input type="hidden" name="action" id="action" value="" />
              <input type="hidden" name="comment_ID" id="comment_ID" value="" />
              <input type="hidden" name="comment_post_ID" id="comment_post_ID" value="" />
              <input type="hidden" name="status" id="status" value="" />
              <input type="hidden" name="position" id="position" value="-1" />
              <input type="hidden" name="checkbox" id="checkbox" value="1" />
              <input type="hidden" name="mode" id="mode" value="detail" />
              <input type="hidden" id="_ajax_nonce-replyto-comment" name="_ajax_nonce-replyto-comment" value="ea08f32b26" />	</fieldset>
          </td></tr></tbody></table>
        </form>
        <div class="hidden" id="trash-undo-holder">
          <div class="trash-undo-inside">
            Comment by <strong></strong> moved to the Trash.		<span class="undo untrash"><a href="#">Undo</a></span>
          </div>
        </div>
        <div class="hidden" id="spam-undo-holder">
          <div class="spam-undo-inside">
            Comment by <strong></strong> marked as spam.		<span class="undo unspam"><a href="#">Undo</a></span>
          </div>
        </div>

        <div class="clear"></div></div><!-- wpbody-content -->
      <div class="clear"></div></div><!-- wpbody -->
    <div class="clear"></div></div><!-- wpcontent -->
  <div id="wp-link-backdrop" style="display: none"></div>
  <div id="wp-link-wrap" class="wp-core-ui" style="display: none" role="dialog" aria-labelledby="link-modal-title">
    <form id="wp-link" tabindex="-1">
      <input type="hidden" id="_ajax_linking_nonce" name="_ajax_linking_nonce" value="80fe8d8ecd" />		<h1 id="link-modal-title">Insert/edit link</h1>
      <button type="button" id="wp-link-close"><span class="screen-reader-text">Close</span></button>
      <div id="link-selector">
        <div id="link-options">
          <p class="howto" id="wplink-enter-url">Enter the destination URL</p>
          <div>
            <label><span>URL</span>
              <input id="wp-link-url" type="text" aria-describedby="wplink-enter-url" /></label>
          </div>
          <div class="wp-link-text-field">
            <label><span>Link Text</span>
              <input id="wp-link-text" type="text" /></label>
          </div>
          <div class="link-target">
            <label><span></span>
              <input type="checkbox" id="wp-link-target" /> Open link in a new tab</label>
          </div>
        </div>
        <p class="howto" id="wplink-link-existing-content">Or link to existing content</p>
        <div id="search-panel">
          <div class="link-search-wrapper">
            <label>
              <span class="search-label">Search</span>
              <input type="search" id="wp-link-search" class="link-search-field" autocomplete="off" aria-describedby="wplink-link-existing-content" />
              <span class="spinner"></span>
            </label>
          </div>
          <div id="search-results" class="query-results" tabindex="0">
            <ul></ul>
            <div class="river-waiting">
              <span class="spinner"></span>
            </div>
          </div>
          <div id="most-recent-results" class="query-results" tabindex="0">
            <div class="query-notice" id="query-notice-message">
              <em class="query-notice-default">No search term specified. Showing recent items.</em>
              <em class="query-notice-hint screen-reader-text">Search or use up and down arrow keys to select an item.</em>
            </div>
            <ul></ul>
            <div class="river-waiting">
              <span class="spinner"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="submitbox">
        <div id="wp-link-cancel">
          <button type="button" class="button">Cancel</button>
        </div>
        <div id="wp-link-update">
          <input type="submit" value="Add Link" class="button button-primary" id="wp-link-submit" name="wp-link-submit">
        </div>
      </div>
    </form>
  </div>
  <div class="clear"></div><!-- wpwrap -->
<?php require "$_SERVER[DOCUMENT_ROOT]/public/admin/layout/fixed-footer.html"; ?>
</div>
</body>
</html>
