<?php
/**
* Copyright (c) Microsoft Corporation.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
* 
* LifecycleManagementSettings File
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
* LifecycleManagementSettings class
*
* @category  Model
* @package   Microsoft.Graph
* @copyright (c) Microsoft Corporation. All rights reserved.
* @license   https://opensource.org/licenses/MIT MIT License
* @link      https://graph.microsoft.com
*/
class LifecycleManagementSettings extends \Beta\Microsoft\Graph\Model\Entity
{
    /**
    * Gets the workflowScheduleIntervalInHours
    *
    * @return int|null The workflowScheduleIntervalInHours
    */
    public function getWorkflowScheduleIntervalInHours()
    {
        if (array_key_exists("workflowScheduleIntervalInHours", $this->_propDict)) {
            return $this->_propDict["workflowScheduleIntervalInHours"];
        } else {
            return null;
        }
    }

    /**
    * Sets the workflowScheduleIntervalInHours
    *
    * @param int $val The workflowScheduleIntervalInHours
    *
    * @return LifecycleManagementSettings
    */
    public function setWorkflowScheduleIntervalInHours($val)
    {
        $this->_propDict["workflowScheduleIntervalInHours"] = intval($val);
        return $this;
    }

}
