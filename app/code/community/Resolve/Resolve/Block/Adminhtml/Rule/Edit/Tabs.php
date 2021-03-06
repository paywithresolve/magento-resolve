<?php
class Resolve_Resolve_Block_Adminhtml_Rule_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('ruleTabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('resolve')->__('Rule Configuration'));
    }

    protected function _beforeToHtml()
    {
        $tabs = array(
            'general'    => 'Payment Restrictions',
            'conditions' => 'Conditions',
        );
        
        foreach ($tabs as $code => $label){
            $label = Mage::helper('resolve')->__($label);
            $content = $this->getLayout()->createBlock('resolve/adminhtml_rule_edit_tab_' . $code)
                ->setTitle($label)
                ->toHtml();
                
            $this->addTab($code, array(
                'label'     => $label,
                'content'   => $content,
            ));
        }
        
        return parent::_beforeToHtml();
    }
}