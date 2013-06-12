<?php

/**
 * Defines the version of speedreading
 *
 * This code fragment is called by moodle_needs_upgrading() and
 * /admin/index.php
 *
 * @package    mod
 * @subpackage speedreading
 * @copyright  2011 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$module->version   = 2012061201;      // The current module version (Date: YYYYMMDDXX)
$module->requires  = 2012061201;      // Requires this Moodle version
$module->cron      = 0;               // Period for cron to check this module (secs)
$module->component = 'mod_speedreading'; // To check on upgrade, that module sits in correct place
