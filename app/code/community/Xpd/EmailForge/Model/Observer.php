<?php 

class Xpd_EmailForge_Model_Observer
{

    public function subscribedToNewsletter(Varien_Event_Observer $observer) 
    {
        if(Mage::getStoreConfig('emailforge/config/enable'))
        {
            $event = $observer->getEvent();
            $subscriber = $event->getDataObject();
            $data = $subscriber->getData();
            
            $subscriber->getEmail();
            
            $universe = Mage::getStoreConfig('emailforge/config/universe');
            $pass = Mage::getStoreConfig('emailforge/config/token');
            $list = Mage::getStoreConfig('emailforge/config/list');
            $resource = 'contact';
            
            $actives_fields = explode(",",Mage::getStoreConfig('emailforge/config/fields'));
            
            $url = "https://$universe:$pass@s3s.fr/api/rest/1/$resource";
            
            $fields = array();
            $fields['email'] = $subscriber->getEmail();
            $fields['lists'] = array();
            $listas = explode(",",$list);
            
            $i = 0;
            foreach($listas as $listinha)
            {
                $fields['lists'][$i]['name'] = $listinha;
                $i += 1;
            }
            
            $customerModel = Mage::getModel("customer/customer");
            $customerModel->setWebsiteId(Mage::app()->getWebsite()->getId());
            $customer = $customerModel->loadByEmail($fields['email']);
            
            if($customer)
            {
                if($customer["firstname"])
                {
                    $fields['firstname'] = $customer["lastname"];
                }
                if($customer["lastname"] && in_array('firstname',$actives_fields))
                {
                    $fields['lastname'] = $customer["lastname"];
                }
                $campos = array();
                
                if($customer['gender'])
                {
                    $campos[0]['name'] = "Sexo";
                    switch((int)$customer['gender'] && in_array('gender',$actives_fields))
                    {
                        case 1: $campos[0]['value'] =  'Masculino'; break;
                        case 2: $campos[0]['value'] =  'Feminino'; break;
                        default: $campos[0]['value'] =  'Masculino'; break;
                    }
                }
                
                $id_address = $customer['default_billing'];
                $address = Mage::getModel('customer/address')->load($id_address)->getData();
                
                if($address)
                {
                    if($customer['telephone'] && in_array('telephone',$actives_fields))
                    {
                        $campos[1]['name'] = "Telefone"; 
                        $campos[1]['value'] = $customer['telephone'];
                    }
                    if($address['postcode'] && in_array('postcode',$actives_fields))
                    {
                        $campos[2]['name'] = "CEP";
                        $campos[2]['value'] = $address['postcode'];
                    }
                    if($address['region_id'] && in_array('region',$actives_fields))
                    {
                        $region = Mage::getModel('directory/region')->load($address['region_id']);
                        $campos[3]['name'] = "Estado";
                        $campos[3]['value'] = $region->getName();
                    }
                }
                
                if($campos)
                {
                   $fields['fields'] = $campos; 
                }
            }
            
            $curlAdapter = new Varien_Http_Adapter_Curl();
            $curlAdapter->setConfig(array('timeout'   => 20));
            $curlAdapter->write(Zend_Http_Client::POST, $url, '1.0', array('Content-Type: application/json','Content-Length: ' . strlen(json_encode($fields))), json_encode($fields));
            $resposta = $curlAdapter->read();
            $retorno = substr($resposta,strpos($resposta, "\r\n\r\n"));
            $curlAdapter->close();
            
            $return = json_decode($retorno);
            
            if($return->{"code"} == "400")
            {
                echo 0;
            }
            elseif($return->{"code"} == "200")
            {
                echo 1;
            }
            
            Mage::log('EmailForge Splio via Observer: '.$return->{"code"}.' - '.$return->{"description"}.' ('.$fields['email'].')');
        }
        
        return $observer;
    }
    
}