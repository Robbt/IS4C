<?php
/*******************************************************************************

    Copyright 2013 Whole Foods Co-op

    This file is part of Fannie.

    IT CORE is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    IT CORE is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    in the file license.txt along with IT CORE; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*********************************************************************************/

/**
  @class WfcHtHoursYearlyModel
*/
class WfcHtHoursYearlyModel extends BasicModel
{

    protected $name = "hoursyearly";

    protected $columns = array(
    'empID' => array('type'=>'INT'),
    'year' => array('type'=>'INT'),
    'regularHours' => array('type'=>'DOUBLE'),
    'overtimeHours' => array('type'=>'DOUBLE'),
    'emergencyHours' => array('type'=>'DOUBLE'),
    'rateHours' => array('type'=>'DOUBLE'),
    'totalHours' => array('type'=>'DOUBLE'),
	);

    public function create()
    {
        $query = "CREATE VIEW hoursalltime AS 
            select empID AS empID,
            year as year,
            sum(hours) AS regularHours,
            sum(OTHours) AS overtimeHours,
            sum(EmergencyHours) AS emergencyHours,
            sum(SecondRateHours) AS rateHours,
            sum(hours) + sum(OTHours) + sum(SecondRateHours) + sum(EmergencyHours) AS totalHours 
            FROM ImportedHoursData group by empID, year";
        $try = $this->connection->query($query);

        if ($try) {
            return true;
        } else {
            return false;
        }
    }

    /* START ACCESSOR FUNCTIONS */

    public function empID()
    {
        if(func_num_args() == 0) {
            if(isset($this->instance["empID"])) {
                return $this->instance["empID"];
            } elseif(isset($this->columns["empID"]["default"])) {
                return $this->columns["empID"]["default"];
            } else {
                return null;
            }
        } else {
            $this->instance["empID"] = func_get_arg(0);
        }
    }

    public function year()
    {
        if(func_num_args() == 0) {
            if(isset($this->instance["year"])) {
                return $this->instance["year"];
            } elseif(isset($this->columns["year"]["default"])) {
                return $this->columns["year"]["default"];
            } else {
                return null;
            }
        } else {
            $this->instance["year"] = func_get_arg(0);
        }
    }

    public function regularHours()
    {
        if(func_num_args() == 0) {
            if(isset($this->instance["regularHours"])) {
                return $this->instance["regularHours"];
            } elseif(isset($this->columns["regularHours"]["default"])) {
                return $this->columns["regularHours"]["default"];
            } else {
                return null;
            }
        } else {
            $this->instance["regularHours"] = func_get_arg(0);
        }
    }

    public function overtimeHours()
    {
        if(func_num_args() == 0) {
            if(isset($this->instance["overtimeHours"])) {
                return $this->instance["overtimeHours"];
            } elseif(isset($this->columns["overtimeHours"]["default"])) {
                return $this->columns["overtimeHours"]["default"];
            } else {
                return null;
            }
        } else {
            $this->instance["overtimeHours"] = func_get_arg(0);
        }
    }

    public function emergencyHours()
    {
        if(func_num_args() == 0) {
            if(isset($this->instance["emergencyHours"])) {
                return $this->instance["emergencyHours"];
            } elseif(isset($this->columns["emergencyHours"]["default"])) {
                return $this->columns["emergencyHours"]["default"];
            } else {
                return null;
            }
        } else {
            $this->instance["emergencyHours"] = func_get_arg(0);
        }
    }

    public function rateHours()
    {
        if(func_num_args() == 0) {
            if(isset($this->instance["rateHours"])) {
                return $this->instance["rateHours"];
            } elseif(isset($this->columns["rateHours"]["default"])) {
                return $this->columns["rateHours"]["default"];
            } else {
                return null;
            }
        } else {
            $this->instance["rateHours"] = func_get_arg(0);
        }
    }

    public function totalHours()
    {
        if(func_num_args() == 0) {
            if(isset($this->instance["totalHours"])) {
                return $this->instance["totalHours"];
            } elseif(isset($this->columns["totalHours"]["default"])) {
                return $this->columns["totalHours"]["default"];
            } else {
                return null;
            }
        } else {
            $this->instance["totalHours"] = func_get_arg(0);
        }
    }
    /* END ACCESSOR FUNCTIONS */
}

