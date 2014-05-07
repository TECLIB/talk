<?php

include ('../../../inc/includes.php');
header("Content-Type: text/html; charset=UTF-8");
Html::header_nocache();

Session::checkLoginUser();

if (!isset($_POST['type'])) {
   exit();
}
if (!isset($_POST['parenttype'])) {
   exit();
}

if (($item = getItemForItemtype($_POST['type']))
    && ($parent = getItemForItemtype($_POST['parenttype']))) {
   if (isset($_POST[$parent->getForeignKeyField()])
       && isset($_POST["id"])
       && $parent->getFromDB($_POST[$parent->getForeignKeyField()])) {
         PluginTalkTicket::showSubForm($item, $_POST["id"], array('parent' => $parent, 
                                                                  'tickets_id' => $_POST["tickets_id"]));
   } else {
      _e('Access denied');
   }
} else if ($_POST['type'] == "Solution") {
   PluginTalkTicket::showSubFormSolution($_POST["tickets_id"]);
}
Html::ajaxFooter();
?>