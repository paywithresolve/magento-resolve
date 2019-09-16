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
class Resolve_Resolve_Block_Payment_Info extends Mage_Payment_Block_Info
{
    /**
     * Url of site
     */
<<<<<<< HEAD
    const RESOLVE_SITE_URL = 'https://www.resolvepay.com/';
=======
    const RESOLVE_SITE_URL = 'https://www.paywithresolve.com/';
>>>>>>> d956e8ba9041c4792c80701bb2d61875ee54a7c9

    /**
     * Set custom template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setData('area','frontend');
        $this->setTemplate('resolve/resolve/payment/info/resolve.phtml');
    }

    /**
     * Get resolve site url
     *
     * @return string
     */
    public function getResolveSiteUrl()
    {
        return self::RESOLVE_SITE_URL;
    }
}
