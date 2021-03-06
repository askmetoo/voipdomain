<?php
/**   ___ ___       ___ _______     ______                        __
 *   |   Y   .-----|   |   _   |   |   _  \ .-----.--------.---.-|__.-----.
 *   |.  |   |  _  |.  |.  1   |   |.  |   \|  _  |        |  _  |  |     |
 *   |.  |   |_____|.  |.  ____|   |.  |    |_____|__|__|__|___._|__|__|__|
 *   |:  1   |     |:  |:  |       |:  1    /
 *    \:.. ./      |::.|::.|       |::.. . /
 *     `---'       `---`---'       `------'
 *
 * Copyright (C) 2016-2018 Ernani José Camargo Azevedo
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * VoIP Domain ranges filter module. This module add the filter calls related
 * to ranges.
 *
 * @author     Ernani José Camargo Azevedo <azevedo@voipdomain.io>
 * @version    1.0
 * @package    VoIP Domain
 * @subpackage Ranges
 * @copyright  2016-2018 Ernani José Camargo Azevedo. All rights reserved
 * @license    https://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Add range's filters
 */
framework_add_filter ( "page_menu_registers", "ranges_menu");
framework_add_filter ( "search_range", "search_range");

/**
 * Function to add entry to registers menu.
 *
 * @param string $buffer Buffer from plugin system if processed by other function
 *                       before
 * @param array $parameters Optional parameters to the function
 * @return array Menus structure
 */
function ranges_menu ( $buffer, $parameters)
{
  return array_merge ( (array) $buffer, array ( array ( "type" => "entry", "icon" => "cloud", "href" => "/ranges", "text" => __ ( "Ranges"))));
}

/**
 * Function to search for a range based on number.
 *
 * @global array $_in Framework global configuration variable
 * @param string $buffer Buffer from plugin system if processed by other function
 *                       before
 * @param array $parameters Optional parameters to the function
 * @return array Output of the found data
 */
function search_range ( $buffer, $parameters)
{
  global $_in;

  /**
   * Check into database if range exists
   */
  if ( $result = @$_in["mysql"]["id"]->query ( "SELECT * FROM `Ranges` WHERE `Start` <= " . $_in["mysql"]["id"]->real_escape_string ( (int) $parameters["number"]) . " AND `Finish` >= " . $_in["mysql"]["id"]->real_escape_string ( (int) $parameters["number"])))
  {
    if ( $result->num_rows != 0)
    {
      $data = $result->fetch_assoc ();
    } else {
      $data = array ();
    }
    $buffer = array_merge ( ( is_array ( $buffer) ? $buffer : array ()), $data);
  }
  return $buffer;
}
?>
