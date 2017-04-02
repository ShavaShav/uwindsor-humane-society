<?php
require_once(dirname(__FILE__) . '/resources/config.php');
require_once(dirname(__FILE__) . '/resources/lib/login-tools.php');
require_once(dirname(__FILE__) . '/resources/lib/database.php');
require_once($TEMPLATES_PATH . '/common.php');

html5_header(
	'Pending Requests',
	array('css/root.css', 'css/pending_requests.css'),
	array());
	
html5_nav();

if ( is_logged_in() && isAdmin() ){
?>

    <!-- Pending adoptions -->
    <div class="pendingBox">
        <h2 class="title">Pending Adoptions</h2>
        <div class="pendingEntryBox">
            <!-- entries to be generated by PHP, get pending entries from db -->
            <div class="pendingEntry">
                <form action="resources/lib/pending_handler.php" method="post">
                    <p>User: <!-- Insert usename --></p>
                    <p>Animal: <!-- Insert usename --></p>
                    <p><a href="img/animals/1.jpg">Image</a></p>

                    <input type="hidden" name="username" value="USERNAME HERE">
                    <input type="hidden" name="id" value="ANIMAL ID HERE">
                    <div class="buttonBox">
                        <button type="submit" name="confirm_adoption" id="confirm_adoption" value="Confirm" class="confirmButton">Confirm</button>
                        <button type="submit" name="deny_adoption" id="deny_adoption" value="Deny" class="denyButton">Deny</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Pending surrenders -->
    <div class="pendingBox">
        <h2 class="title">Pending Surrenders</h2>
        <div class="pendingEntryBox">
            <!-- entries to be generated by PHP, get pending entries from db -->
            <div class="pendingEntry">
                <form action="resources/lib/pending_handler.php" method="post">
                    <p>User: <!-- Insert usename --></p>
                    <p>Animal: <!-- Insert usename --></p>
                    <p><a href="img/surrenders/1.jpg">Image</a></p>

                    <input type="hidden" name="username" value="USERNAME HERE">
                    <input type="hidden" name="animal_id" value="ANIMAL SURRENDER ID HERE">
                    <div class="buttonBox">
                        <button type="submit" name="confirm_surrender" id="confirm_surrender" value="Confirm" class="confirmButton">Confirm</button>
                        <button type="submit" name="deny_surrender" id="deny_surrender" value="Deny" class="denyButton">Deny</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
} else { // end if admin
?>

<!-- this is just a safety precaution in case a user manually types in url to this page -->
    <p style="text-align:center">Sorry, you are not authorized to view this page!</p>

<?php
} // end if not admin

html5_footer();
?>