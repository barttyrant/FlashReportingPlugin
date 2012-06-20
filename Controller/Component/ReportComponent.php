<?php

/**
 * Dedicated component for handling simple flash-messages
 * @version 2.0
 * @author Bart Tyrant
 * 
 * @property SessionComponent $Session
 * @property AppController $controller
 */
class ReportComponent extends Component {

    public $controller = null;
    public $components = array('Session','Auth');
    
    protected $_settings = null; //setSettings
    
    
    protected $_defaultSettings = array(
        'elementError' => 'flash/error',
        'elementWarning' => 'flash/warning',
        'elementInfo' => 'flash/info',
        'elementSuccess' => 'flash/success',
        'flashCssClass' => 'flashMessage',
    );


    function initialize(&$controller, $settings = array()) {
        $this->controller =& $controller;        
        $this->setSettings($settings);
    }
    
    /**
     * sets up the component settings
     * @param array $settings 
     */
    public function setSettings($settings) {
        $this->_settings = array_merge($this->_defaultSettings, $settings);
    }
    
    
    
    // <editor-fold desc="*** Flash methods ***">  
    
    /**
     * Info flash message
     * @param type $message
     * @param type $params 
     */
    public function info($message, $params = array()){
        $params['type'] = 'info';
        return $this->_flashMessage($message, $params);
    }
    
    
    /**
     * Info flash message
     * @param type $message
     * @param type $params 
     */
    public function success($message, $params = array()){
        $params['type'] = 'success';
        return $this->_flashMessage($message, $params);
    }
    
    
    /**
     * Info flash message
     * @param type $message
     * @param type $params 
     */
    public function warning($message, $params = array()){
        $params['type'] = 'warning';
        return $this->_flashMessage($message, $params);
    }
    
    
    /**
     * Info flash message
     * @param type $message
     * @param type $params 
     */
    public function error($message, $params = array()){
        $params['type'] = 'error';
        return $this->_flashMessage($message, $params);
    }
    
   
    /**
     * General flash message preparing
     * @param String $message
     * @param Array $params 
     */
    protected function _flashMessage($message, $params = array()) {
        $defaultElement = isset($params['type']) ? $this->_settings['element' . ucfirst($params['type'])] : 'default';
        $_defaultParams = array(
            'element' => $defaultElement,
            'key' => 'flash',
            'params' => $params,
            'redirect' => false,
            'autohide' => false,
            'class' => array()
        );
        
        $params = array_merge($_defaultParams, $params);

        $uniqueFlashId = md5(implode(':', array($message, $params['type'])));
        
        $params['divId'] = 'flashMessage_' . $uniqueFlashId;
        
        $this->Session->setFlash($message, $params['element'], $params, $params['key']);
        
        if($params['redirect'] === true){
            return $this->controller->redirect($this->controller->referer());
        }
        elseif($params['redirect'] !== false){
            return $this->controller->redirect($params['redirect']);
        }        
    }
    
    //</editor-fold>    

}