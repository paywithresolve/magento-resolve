<?php
/**
 * OnePica
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to codemaster@onepica.com so we can send you a copy immediately.
 *
 * @category    Resolve
 * @package     Resolve_Resolve
 * @copyright   Copyright (c) 2014 One Pica, Inc. (http://www.onepica.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Resolve_Resolve_Model_Compatibility_Tool_ClassRewrites
    extends Resolve_Resolve_Model_Compatibility_Tool_Entity_Abstract
{
    /**#@+
     * Define constants
     */
    const CONFLICT_TYPE = 'model';
    const CACHE_KEY_XML = 'RESOLVE_RESOLVE_COMPATIBILITY_XML_CLASS';
    const CACHE_KEY_CODE_POOL = 'RESOLVE_RESOLVE_COMPATIBILITY_CODE_POOL_CLASS';
    /**#@-*/

    /**
     * Get used classes with methods in resolve
     *
     * @return array
     */
    protected function _getUsedClassMethods()
    {
        return array(
            'Mage_Sales_Model_Quote' => array('setReservedOrderId', 'save'),
            'Mage_Sales_Model_Order' => array('loadByIncrementId', 'save', 'getBillingAddress')
        );
    }

    /**
     * Get group Id
     *
     * @param array $parts
     * @return string
     */
    protected function _getGroupId($parts)
    {
        return isset($parts[1]) ? strtolower($parts[1]): '';
    }

    /**
     * Get class Id
     *
     * @param array $parts
     * @return string
     */
    protected function _getClassId($parts)
    {
        return isset($parts[3]) ? strtolower($parts[3]): '';
    }

    /**
     * Get rewrites in code pool
     *
     * @return array
     */
    public function getCodePoolClassRewrite()
    {
        $cache = Mage::app()->loadCache(self::CACHE_KEY_CODE_POOL);
        if ($this->useCache() && $cache) {
            $classCodePoolRewrite = json_decode($cache, true);
        } else {
            $classCodePoolRewrite = array();
            $usedClasses = $this->_getUsedClassMethods();
            foreach ($usedClasses as $class => $methods) {
                $refl = new ReflectionClass($class);
                $filename = $refl->getFileName();
                $pathByName = str_replace('_', DS, $class) . '.php';
                if ((strpos($filename, 'local' . DS . $pathByName) !== false) ||
                    (strpos($filename, 'community'. DS . $pathByName) !== false))
                {
                    $classCodePoolRewrite[] = $class;
                }
            }
            if ($this->useCache()) {
                Mage::app()->saveCache(json_encode($classCodePoolRewrite), self::CACHE_KEY_CODE_POOL,
                    array(self::CACHE_TYPE));
            }
        }
        return $classCodePoolRewrite;
    }

    /**
     * Get rewrites in xml
     *
     * @return array
     */
    public function getXmlClassRewrites()
    {
        $cache = Mage::app()->loadCache(self::CACHE_KEY_XML);
        if ($this->useCache() && $cache) {
            $result = json_decode($cache, true);
        } else {
            $classRewrites = array();
            $modules = $this->_getAllModules();

            foreach ($modules as $modName => $module) {
                if ($this->_skipValidation($modName, $module)) {
                    continue;
                }
                $result = $this->_getRewritesInModule($modName);
                if (!empty($result)) {
                    $classRewrites[] = $result;
                }
            }
            $result = $this->_getClassMethodRewrites($classRewrites);
            if ($this->useCache()) {
                Mage::app()->saveCache(json_encode($result), self::CACHE_KEY_XML,
                    array(self::CACHE_TYPE));
            }
        }
        return $result;
    }

    /**
     * Get class methods rewrites
     *
     * @param array $classRewrites
     * @return array
     */
    protected function _getClassMethodRewrites($classRewrites)
    {
        $usedClasses = $this->_getUsedClassMethods();
        foreach ($classRewrites as $position => &$usedClass) {
            foreach ($usedClass as $class => &$rewrites) {
                if (isset($rewrites['class'])) {
                    $refl = new ReflectionClass($rewrites['class']);
                    foreach ($usedClasses[$class] as $method) {
                        $classOwner = $refl->getMethod($method)->class;
                        if (($class != $classOwner) && !in_array($method, $rewrites['methods'])) {
                                array_push($rewrites['methods'], $method);
                        }
                    }
                }
            }
        }
        return $classRewrites;
    }

    /**
     * Get rewrites in separate module
     *
     * @param string $modName
     * @return array
     */
    protected function _getRewritesInModule($modName)
    {
        $classes = array();
        $moduleConfig = $this->_getModuleConfig($modName);

        $usedClasses = $this->_getUsedClassMethods();
        foreach ($usedClasses as $class => $methods) {
            $parts = explode('_', $class);
            $groupId = $this->_getGroupId($parts);
            $classId = $this->_getClassId($parts);
            if (!$groupId || ! $classId) {
                continue;
            }
            $typeNode = $moduleConfig->getNode()->global->{self::CONFLICT_TYPE . 's'}->$groupId;
            if (!$typeNode) {
                continue;
            };

            $rewrites = $typeNode->rewrite;

            if ($rewrites && $rewrites->$classId) {
                $classes[$class] = array('class' => (string) $rewrites->$classId, 'methods' => array());
            }
        }
        return $classes;
    }
}
