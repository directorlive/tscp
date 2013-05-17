<?
session_start();
require_once('Cron_Config.php');
require_once('salesforce_auto_login.php');
require_once('REST/get_updated_leads.php');
require_once('REST/get_updated_contacts.php');
updateData("DELETE from available_agents where TIMESTAMPDIFF(MINUTE,`last_online`,NOW())>5");