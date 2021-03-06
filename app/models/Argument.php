<?php
/**
 * This file is part of the Go-Smart Simulation Architecture (GSSA).
 * Go-Smart is an EU-FP7 project, funded by the European Commission.
 *
 * Copyright (C) 2013-  NUMA Engineering Ltd. (see AUTHORS file)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */



class Argument extends UuidModel {

  /**
   * Look after created_at and modified_at properties automatically
   *
   * @var boolean
   */
  public $timestamps = false;

  protected static $updateByDefault = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Argument';

  public function NumericalModels() {
    return $this->belongsToMany('NumericalModel', 'Numerical_Model_Argument', 'Argument_Id', 'Numerical_Model_Id');
  }

  public function Algorithms() {
    return $this->belongsToMany('Algorithm', 'Algorithm_Argument', 'Argument_Id', 'Algorithm_Id');
  }

  public function xml($parent)
  {
    $argument = new DOMElement("argument");
    $parent->appendChild($argument);
    $argument->setAttribute("name", $this->Name);
  }

  public function findUnique()
  {
    return false;
  }
}
