<?php
/**
* Copyright (c) Microsoft Corporation.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
* 
* Workflow File
* PHP version 7
*
* @category  Library
* @package   Microsoft.Graph
* @copyright (c) Microsoft Corporation. All rights reserved.
* @license   https://opensource.org/licenses/MIT MIT License
* @link      https://graph.microsoft.com
*/
namespace Beta\Microsoft\Graph\IdentityGovernance\Model;

/**
* Workflow class
*
* @category  Model
* @package   Microsoft.Graph
* @copyright (c) Microsoft Corporation. All rights reserved.
* @license   https://opensource.org/licenses/MIT MIT License
* @link      https://graph.microsoft.com
*/
class Workflow extends WorkflowBase
{
    /**
    * Gets the deletedDateTime
    *
    * @return \DateTime|null The deletedDateTime
    */
    public function getDeletedDateTime()
    {
        if (array_key_exists("deletedDateTime", $this->_propDict)) {
            if (is_a($this->_propDict["deletedDateTime"], "\DateTime") || is_null($this->_propDict["deletedDateTime"])) {
                return $this->_propDict["deletedDateTime"];
            } else {
                $this->_propDict["deletedDateTime"] = new \DateTime($this->_propDict["deletedDateTime"]);
                return $this->_propDict["deletedDateTime"];
            }
        }
        return null;
    }

    /**
    * Sets the deletedDateTime
    *
    * @param \DateTime $val The deletedDateTime
    *
    * @return Workflow
    */
    public function setDeletedDateTime($val)
    {
        $this->_propDict["deletedDateTime"] = $val;
        return $this;
    }

    /**
    * Gets the id
    *
    * @return string|null The id
    */
    public function getId()
    {
        if (array_key_exists("id", $this->_propDict)) {
            return $this->_propDict["id"];
        } else {
            return null;
        }
    }

    /**
    * Sets the id
    *
    * @param string $val The id
    *
    * @return Workflow
    */
    public function setId($val)
    {
        $this->_propDict["id"] = $val;
        return $this;
    }

    /**
    * Gets the isEnabled
    *
    * @return bool|null The isEnabled
    */
    public function getIsEnabled()
    {
        if (array_key_exists("isEnabled", $this->_propDict)) {
            return $this->_propDict["isEnabled"];
        } else {
            return null;
        }
    }

    /**
    * Sets the isEnabled
    *
    * @param bool $val The isEnabled
    *
    * @return Workflow
    */
    public function setIsEnabled($val)
    {
        $this->_propDict["isEnabled"] = boolval($val);
        return $this;
    }

    /**
    * Gets the isSchedulingEnabled
    *
    * @return bool|null The isSchedulingEnabled
    */
    public function getIsSchedulingEnabled()
    {
        if (array_key_exists("isSchedulingEnabled", $this->_propDict)) {
            return $this->_propDict["isSchedulingEnabled"];
        } else {
            return null;
        }
    }

    /**
    * Sets the isSchedulingEnabled
    *
    * @param bool $val The isSchedulingEnabled
    *
    * @return Workflow
    */
    public function setIsSchedulingEnabled($val)
    {
        $this->_propDict["isSchedulingEnabled"] = boolval($val);
        return $this;
    }

    /**
    * Gets the nextScheduleRunDateTime
    *
    * @return \DateTime|null The nextScheduleRunDateTime
    */
    public function getNextScheduleRunDateTime()
    {
        if (array_key_exists("nextScheduleRunDateTime", $this->_propDict)) {
            if (is_a($this->_propDict["nextScheduleRunDateTime"], "\DateTime") || is_null($this->_propDict["nextScheduleRunDateTime"])) {
                return $this->_propDict["nextScheduleRunDateTime"];
            } else {
                $this->_propDict["nextScheduleRunDateTime"] = new \DateTime($this->_propDict["nextScheduleRunDateTime"]);
                return $this->_propDict["nextScheduleRunDateTime"];
            }
        }
        return null;
    }

    /**
    * Sets the nextScheduleRunDateTime
    *
    * @param \DateTime $val The nextScheduleRunDateTime
    *
    * @return Workflow
    */
    public function setNextScheduleRunDateTime($val)
    {
        $this->_propDict["nextScheduleRunDateTime"] = $val;
        return $this;
    }

    /**
    * Gets the version
    *
    * @return int|null The version
    */
    public function getVersion()
    {
        if (array_key_exists("version", $this->_propDict)) {
            return $this->_propDict["version"];
        } else {
            return null;
        }
    }

    /**
    * Sets the version
    *
    * @param int $val The version
    *
    * @return Workflow
    */
    public function setVersion($val)
    {
        $this->_propDict["version"] = intval($val);
        return $this;
    }


     /**
     * Gets the executionScope
     *
     * @return array|null The executionScope
     */
    public function getExecutionScope()
    {
        if (array_key_exists("executionScope", $this->_propDict)) {
           return $this->_propDict["executionScope"];
        } else {
            return null;
        }
    }

    /**
    * Sets the executionScope
    *
    * @param \Beta\Microsoft\Graph\Model\User[] $val The executionScope
    *
    * @return Workflow
    */
    public function setExecutionScope($val)
    {
        $this->_propDict["executionScope"] = $val;
        return $this;
    }


     /**
     * Gets the runs
     *
     * @return array|null The runs
     */
    public function getRuns()
    {
        if (array_key_exists("runs", $this->_propDict)) {
           return $this->_propDict["runs"];
        } else {
            return null;
        }
    }

    /**
    * Sets the runs
    *
    * @param Run[] $val The runs
    *
    * @return Workflow
    */
    public function setRuns($val)
    {
        $this->_propDict["runs"] = $val;
        return $this;
    }


     /**
     * Gets the taskReports
     *
     * @return array|null The taskReports
     */
    public function getTaskReports()
    {
        if (array_key_exists("taskReports", $this->_propDict)) {
           return $this->_propDict["taskReports"];
        } else {
            return null;
        }
    }

    /**
    * Sets the taskReports
    *
    * @param TaskReport[] $val The taskReports
    *
    * @return Workflow
    */
    public function setTaskReports($val)
    {
        $this->_propDict["taskReports"] = $val;
        return $this;
    }


     /**
     * Gets the userProcessingResults
     *
     * @return array|null The userProcessingResults
     */
    public function getUserProcessingResults()
    {
        if (array_key_exists("userProcessingResults", $this->_propDict)) {
           return $this->_propDict["userProcessingResults"];
        } else {
            return null;
        }
    }

    /**
    * Sets the userProcessingResults
    *
    * @param UserProcessingResult[] $val The userProcessingResults
    *
    * @return Workflow
    */
    public function setUserProcessingResults($val)
    {
        $this->_propDict["userProcessingResults"] = $val;
        return $this;
    }


     /**
     * Gets the versions
     *
     * @return array|null The versions
     */
    public function getVersions()
    {
        if (array_key_exists("versions", $this->_propDict)) {
           return $this->_propDict["versions"];
        } else {
            return null;
        }
    }

    /**
    * Sets the versions
    *
    * @param WorkflowVersion[] $val The versions
    *
    * @return Workflow
    */
    public function setVersions($val)
    {
        $this->_propDict["versions"] = $val;
        return $this;
    }

}
