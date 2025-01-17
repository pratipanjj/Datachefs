<?php
/**
* Copyright (c) Microsoft Corporation.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
* 
* TaskReport File
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
* TaskReport class
*
* @category  Model
* @package   Microsoft.Graph
* @copyright (c) Microsoft Corporation. All rights reserved.
* @license   https://opensource.org/licenses/MIT MIT License
* @link      https://graph.microsoft.com
*/
class TaskReport extends \Beta\Microsoft\Graph\Model\Entity
{
    /**
    * Gets the completedDateTime
    *
    * @return \DateTime|null The completedDateTime
    */
    public function getCompletedDateTime()
    {
        if (array_key_exists("completedDateTime", $this->_propDict)) {
            if (is_a($this->_propDict["completedDateTime"], "\DateTime") || is_null($this->_propDict["completedDateTime"])) {
                return $this->_propDict["completedDateTime"];
            } else {
                $this->_propDict["completedDateTime"] = new \DateTime($this->_propDict["completedDateTime"]);
                return $this->_propDict["completedDateTime"];
            }
        }
        return null;
    }

    /**
    * Sets the completedDateTime
    *
    * @param \DateTime $val The completedDateTime
    *
    * @return TaskReport
    */
    public function setCompletedDateTime($val)
    {
        $this->_propDict["completedDateTime"] = $val;
        return $this;
    }

    /**
    * Gets the failedUsersCount
    *
    * @return int|null The failedUsersCount
    */
    public function getFailedUsersCount()
    {
        if (array_key_exists("failedUsersCount", $this->_propDict)) {
            return $this->_propDict["failedUsersCount"];
        } else {
            return null;
        }
    }

    /**
    * Sets the failedUsersCount
    *
    * @param int $val The failedUsersCount
    *
    * @return TaskReport
    */
    public function setFailedUsersCount($val)
    {
        $this->_propDict["failedUsersCount"] = intval($val);
        return $this;
    }

    /**
    * Gets the lastUpdatedDateTime
    *
    * @return \DateTime|null The lastUpdatedDateTime
    */
    public function getLastUpdatedDateTime()
    {
        if (array_key_exists("lastUpdatedDateTime", $this->_propDict)) {
            if (is_a($this->_propDict["lastUpdatedDateTime"], "\DateTime") || is_null($this->_propDict["lastUpdatedDateTime"])) {
                return $this->_propDict["lastUpdatedDateTime"];
            } else {
                $this->_propDict["lastUpdatedDateTime"] = new \DateTime($this->_propDict["lastUpdatedDateTime"]);
                return $this->_propDict["lastUpdatedDateTime"];
            }
        }
        return null;
    }

    /**
    * Sets the lastUpdatedDateTime
    *
    * @param \DateTime $val The lastUpdatedDateTime
    *
    * @return TaskReport
    */
    public function setLastUpdatedDateTime($val)
    {
        $this->_propDict["lastUpdatedDateTime"] = $val;
        return $this;
    }

    /**
    * Gets the processingStatus
    *
    * @return LifecycleWorkflowProcessingStatus|null The processingStatus
    */
    public function getProcessingStatus()
    {
        if (array_key_exists("processingStatus", $this->_propDict)) {
            if (is_a($this->_propDict["processingStatus"], "\Beta\Microsoft\Graph\IdentityGovernance\Model\LifecycleWorkflowProcessingStatus") || is_null($this->_propDict["processingStatus"])) {
                return $this->_propDict["processingStatus"];
            } else {
                $this->_propDict["processingStatus"] = new LifecycleWorkflowProcessingStatus($this->_propDict["processingStatus"]);
                return $this->_propDict["processingStatus"];
            }
        }
        return null;
    }

    /**
    * Sets the processingStatus
    *
    * @param LifecycleWorkflowProcessingStatus $val The processingStatus
    *
    * @return TaskReport
    */
    public function setProcessingStatus($val)
    {
        $this->_propDict["processingStatus"] = $val;
        return $this;
    }

    /**
    * Gets the runId
    *
    * @return string|null The runId
    */
    public function getRunId()
    {
        if (array_key_exists("runId", $this->_propDict)) {
            return $this->_propDict["runId"];
        } else {
            return null;
        }
    }

    /**
    * Sets the runId
    *
    * @param string $val The runId
    *
    * @return TaskReport
    */
    public function setRunId($val)
    {
        $this->_propDict["runId"] = $val;
        return $this;
    }

    /**
    * Gets the startedDateTime
    *
    * @return \DateTime|null The startedDateTime
    */
    public function getStartedDateTime()
    {
        if (array_key_exists("startedDateTime", $this->_propDict)) {
            if (is_a($this->_propDict["startedDateTime"], "\DateTime") || is_null($this->_propDict["startedDateTime"])) {
                return $this->_propDict["startedDateTime"];
            } else {
                $this->_propDict["startedDateTime"] = new \DateTime($this->_propDict["startedDateTime"]);
                return $this->_propDict["startedDateTime"];
            }
        }
        return null;
    }

    /**
    * Sets the startedDateTime
    *
    * @param \DateTime $val The startedDateTime
    *
    * @return TaskReport
    */
    public function setStartedDateTime($val)
    {
        $this->_propDict["startedDateTime"] = $val;
        return $this;
    }

    /**
    * Gets the successfulUsersCount
    *
    * @return int|null The successfulUsersCount
    */
    public function getSuccessfulUsersCount()
    {
        if (array_key_exists("successfulUsersCount", $this->_propDict)) {
            return $this->_propDict["successfulUsersCount"];
        } else {
            return null;
        }
    }

    /**
    * Sets the successfulUsersCount
    *
    * @param int $val The successfulUsersCount
    *
    * @return TaskReport
    */
    public function setSuccessfulUsersCount($val)
    {
        $this->_propDict["successfulUsersCount"] = intval($val);
        return $this;
    }

    /**
    * Gets the totalUsersCount
    *
    * @return int|null The totalUsersCount
    */
    public function getTotalUsersCount()
    {
        if (array_key_exists("totalUsersCount", $this->_propDict)) {
            return $this->_propDict["totalUsersCount"];
        } else {
            return null;
        }
    }

    /**
    * Sets the totalUsersCount
    *
    * @param int $val The totalUsersCount
    *
    * @return TaskReport
    */
    public function setTotalUsersCount($val)
    {
        $this->_propDict["totalUsersCount"] = intval($val);
        return $this;
    }

    /**
    * Gets the unprocessedUsersCount
    *
    * @return int|null The unprocessedUsersCount
    */
    public function getUnprocessedUsersCount()
    {
        if (array_key_exists("unprocessedUsersCount", $this->_propDict)) {
            return $this->_propDict["unprocessedUsersCount"];
        } else {
            return null;
        }
    }

    /**
    * Sets the unprocessedUsersCount
    *
    * @param int $val The unprocessedUsersCount
    *
    * @return TaskReport
    */
    public function setUnprocessedUsersCount($val)
    {
        $this->_propDict["unprocessedUsersCount"] = intval($val);
        return $this;
    }

    /**
    * Gets the task
    *
    * @return Task|null The task
    */
    public function getTask()
    {
        if (array_key_exists("task", $this->_propDict)) {
            if (is_a($this->_propDict["task"], "\Beta\Microsoft\Graph\IdentityGovernance\Model\Task") || is_null($this->_propDict["task"])) {
                return $this->_propDict["task"];
            } else {
                $this->_propDict["task"] = new Task($this->_propDict["task"]);
                return $this->_propDict["task"];
            }
        }
        return null;
    }

    /**
    * Sets the task
    *
    * @param Task $val The task
    *
    * @return TaskReport
    */
    public function setTask($val)
    {
        $this->_propDict["task"] = $val;
        return $this;
    }

    /**
    * Gets the taskDefinition
    *
    * @return TaskDefinition|null The taskDefinition
    */
    public function getTaskDefinition()
    {
        if (array_key_exists("taskDefinition", $this->_propDict)) {
            if (is_a($this->_propDict["taskDefinition"], "\Beta\Microsoft\Graph\IdentityGovernance\Model\TaskDefinition") || is_null($this->_propDict["taskDefinition"])) {
                return $this->_propDict["taskDefinition"];
            } else {
                $this->_propDict["taskDefinition"] = new TaskDefinition($this->_propDict["taskDefinition"]);
                return $this->_propDict["taskDefinition"];
            }
        }
        return null;
    }

    /**
    * Sets the taskDefinition
    *
    * @param TaskDefinition $val The taskDefinition
    *
    * @return TaskReport
    */
    public function setTaskDefinition($val)
    {
        $this->_propDict["taskDefinition"] = $val;
        return $this;
    }


     /**
     * Gets the taskProcessingResults
     *
     * @return array|null The taskProcessingResults
     */
    public function getTaskProcessingResults()
    {
        if (array_key_exists("taskProcessingResults", $this->_propDict)) {
           return $this->_propDict["taskProcessingResults"];
        } else {
            return null;
        }
    }

    /**
    * Sets the taskProcessingResults
    *
    * @param TaskProcessingResult[] $val The taskProcessingResults
    *
    * @return TaskReport
    */
    public function setTaskProcessingResults($val)
    {
        $this->_propDict["taskProcessingResults"] = $val;
        return $this;
    }

}
