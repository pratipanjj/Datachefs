<?php
/**
* Copyright (c) Microsoft Corporation.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
* 
* TimeBasedAttributeTrigger File
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
* TimeBasedAttributeTrigger class
*
* @category  Model
* @package   Microsoft.Graph
* @copyright (c) Microsoft Corporation. All rights reserved.
* @license   https://opensource.org/licenses/MIT MIT License
* @link      https://graph.microsoft.com
*/
class TimeBasedAttributeTrigger extends WorkflowExecutionTrigger
{
    /**
    * Gets the offsetInDays
    *
    * @return int|null The offsetInDays
    */
    public function getOffsetInDays()
    {
        if (array_key_exists("offsetInDays", $this->_propDict)) {
            return $this->_propDict["offsetInDays"];
        } else {
            return null;
        }
    }

    /**
    * Sets the offsetInDays
    *
    * @param int $val The value of the offsetInDays
    *
    * @return TimeBasedAttributeTrigger
    */
    public function setOffsetInDays($val)
    {
        $this->_propDict["offsetInDays"] = $val;
        return $this;
    }

    /**
    * Gets the timeBasedAttribute
    *
    * @return WorkflowTriggerTimeBasedAttribute|null The timeBasedAttribute
    */
    public function getTimeBasedAttribute()
    {
        if (array_key_exists("timeBasedAttribute", $this->_propDict)) {
            if (is_a($this->_propDict["timeBasedAttribute"], "\Beta\Microsoft\Graph\IdentityGovernance\Model\WorkflowTriggerTimeBasedAttribute") || is_null($this->_propDict["timeBasedAttribute"])) {
                return $this->_propDict["timeBasedAttribute"];
            } else {
                $this->_propDict["timeBasedAttribute"] = new WorkflowTriggerTimeBasedAttribute($this->_propDict["timeBasedAttribute"]);
                return $this->_propDict["timeBasedAttribute"];
            }
        }
        return null;
    }

    /**
    * Sets the timeBasedAttribute
    *
    * @param WorkflowTriggerTimeBasedAttribute $val The value to assign to the timeBasedAttribute
    *
    * @return TimeBasedAttributeTrigger The TimeBasedAttributeTrigger
    */
    public function setTimeBasedAttribute($val)
    {
        $this->_propDict["timeBasedAttribute"] = $val;
         return $this;
    }
}
