<?php
/**
* Copyright (c) Microsoft Corporation.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
* 
* TaskDefinition File
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
* TaskDefinition class
*
* @category  Model
* @package   Microsoft.Graph
* @copyright (c) Microsoft Corporation. All rights reserved.
* @license   https://opensource.org/licenses/MIT MIT License
* @link      https://graph.microsoft.com
*/
class TaskDefinition extends \Beta\Microsoft\Graph\Model\Entity
{
    /**
    * Gets the category
    *
    * @return LifecycleTaskCategory|null The category
    */
    public function getCategory()
    {
        if (array_key_exists("category", $this->_propDict)) {
            if (is_a($this->_propDict["category"], "\Beta\Microsoft\Graph\IdentityGovernance\Model\LifecycleTaskCategory") || is_null($this->_propDict["category"])) {
                return $this->_propDict["category"];
            } else {
                $this->_propDict["category"] = new LifecycleTaskCategory($this->_propDict["category"]);
                return $this->_propDict["category"];
            }
        }
        return null;
    }

    /**
    * Sets the category
    *
    * @param LifecycleTaskCategory $val The category
    *
    * @return TaskDefinition
    */
    public function setCategory($val)
    {
        $this->_propDict["category"] = $val;
        return $this;
    }

    /**
    * Gets the continueOnError
    *
    * @return bool|null The continueOnError
    */
    public function getContinueOnError()
    {
        if (array_key_exists("continueOnError", $this->_propDict)) {
            return $this->_propDict["continueOnError"];
        } else {
            return null;
        }
    }

    /**
    * Sets the continueOnError
    *
    * @param bool $val The continueOnError
    *
    * @return TaskDefinition
    */
    public function setContinueOnError($val)
    {
        $this->_propDict["continueOnError"] = boolval($val);
        return $this;
    }

    /**
    * Gets the description
    *
    * @return string|null The description
    */
    public function getDescription()
    {
        if (array_key_exists("description", $this->_propDict)) {
            return $this->_propDict["description"];
        } else {
            return null;
        }
    }

    /**
    * Sets the description
    *
    * @param string $val The description
    *
    * @return TaskDefinition
    */
    public function setDescription($val)
    {
        $this->_propDict["description"] = $val;
        return $this;
    }

    /**
    * Gets the displayName
    *
    * @return string|null The displayName
    */
    public function getDisplayName()
    {
        if (array_key_exists("displayName", $this->_propDict)) {
            return $this->_propDict["displayName"];
        } else {
            return null;
        }
    }

    /**
    * Sets the displayName
    *
    * @param string $val The displayName
    *
    * @return TaskDefinition
    */
    public function setDisplayName($val)
    {
        $this->_propDict["displayName"] = $val;
        return $this;
    }


     /**
     * Gets the parameters
     *
     * @return array|null The parameters
     */
    public function getParameters()
    {
        if (array_key_exists("parameters", $this->_propDict)) {
           return $this->_propDict["parameters"];
        } else {
            return null;
        }
    }

    /**
    * Sets the parameters
    *
    * @param Parameter[] $val The parameters
    *
    * @return TaskDefinition
    */
    public function setParameters($val)
    {
        $this->_propDict["parameters"] = $val;
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
    * @return TaskDefinition
    */
    public function setVersion($val)
    {
        $this->_propDict["version"] = intval($val);
        return $this;
    }

}
