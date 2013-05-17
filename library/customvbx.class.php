<?
//******************************Twilio SMS Sender Class *******************************
require("twilio/Twilio.php");
require_once("cUrl/class.curl.php");
require_once('Config.php');
require_once('commonFunctions.php');
//require_once('cUrl/class.curl.php');


class TwilioExt
{
	var $accountSid;
	var $authToken;
	var $appSid;
	var $twilioClient;
	
	function TwilioExt()
	{
		$twilioCreds = getTwlioCreds();
		$this->accountSid = $twilioCreds['sid'];
		$this->authToken =  $twilioCreds['auth_token'];
		$this->appSid = $twilioCreds['app_sid'];
	}
	
	function searchForPhoneNumber($match)
	{
		
		$SearchParams = array();
		$availableNumbers = array();
		$buyNumber = "000";
 		$phone = $match;
		$first3 = "";
		$SearchParams['InPostalCode'] = '';
        $SearchParams['NearNumber'] = '';
        $SearchParams['Contains'] = '';
		
		$twiCli = new Services_Twilio($this->accountSid, $this->authToken);
		
		if(trim($phone) != "") 	
		{	
			$first3 = substr($phone,0,3);
			$first2 = substr($phone,0,2);
			$first1 = substr($phone,0,1);	
			$SearchParams['Contains'] = $first3.'*******' ; 
		}
		
        //$postalCode = getOne("select zip from users where id = '".$user_id."'");
		/* Search parameters for US Local PhoneNumbers */
        
 
        try 
		{
 			// For first 3 match
            /* Initiate US Local PhoneNumber search with $SearchParams list */
            $numbers = $twiCli->account->available_phone_numbers->getList('GB', 'Local', $SearchParams);
 
            /* If we did not find any phone numbers let the user know */
            $chk = 0;
			foreach($numbers->available_phone_numbers as $numberT)
			{
				$chk++;
			}
			
			// For first 2 match
			if($chk==0) 
			{
                $SearchParams['Contains'] = $first2.'*******' ;
				$numbers = $twiCli->account->available_phone_numbers->getList('GB', 'Local', $SearchParams);
				
				 /* If we did not find any phone numbers let the user know */
				$chk = 0;
				foreach($numbers->available_phone_numbers as $numberT)
				{
					$chk++;
				}
				// For first 1 match
				if($chk==0) 
				{
					$SearchParams['Contains'] = $first1.'*******' ;
					$numbers = $twiCli->account->available_phone_numbers->getList('GB', 'Local', $SearchParams);
					
					$chk = 0;
					foreach($numbers->available_phone_numbers as $numberT)
					{
						$chk++;
					}
					// For first 0 match
					if($chk==0) 
					{
						$SearchParams['Contains'] = '' ;
						$numbers = $twiCli->account->available_phone_numbers->getList('GB', 'Local', $SearchParams);
					}
				}			
            }	
			
						
			foreach($numbers->available_phone_numbers as $number)
			{
				$availableNumbers[] = $number;
			}
			
			return $availableNumbers;
					
 
        } 
		catch (Exception $e) 
		{          
 				echo $e->getMessage();
		}
	
	}
	
	function buyNumber($twilioNumber)
	{
		$twiCli = new Services_Twilio($this->accountSid, $this->authToken);
		try {
 
            // POST the AreaCode to buy in to the IncomingPhoneNumbers resource
            $number = $twiCli->account->incoming_phone_numbers->create(array(
                "PhoneNumber" => $twilioNumber,
				"VoiceApplicationSid" => $this->appSid,
				"SmsApplicationSid" => $this->appSid,
            ));
 
            return "Success";
 
        } catch (Exception $e) {
 
            // If we weren't able to process the request successfully, return
            // the error back to the user
            return $err = "Error processing request for $twilioNumber: {$e->getMessage()}";
 
        }
	}
	
	function buyNewNumber($twilioNumber)
	{
		//$subscriptionReference = getOne("select subscription_reference from account_subscriptions where userid = '".$userId."' and active = '1'");
		
		echo $refUrl = "https://api.twilio.com/2010-04-01/Accounts/".$this->accountSid."/IncomingPhoneNumbers?PhoneNumber=".$twilioNumber;
		
		
		$data = "<IncomingPhoneNumber><PhoneNumber>".$twilioNumber."</PhoneNumber></IncomingPhoneNumber>";
		
		$c = new curl($refUrl);
		$c->setopt(CURLOPT_HEADER, true);
			$c->setopt(CURLOPT_RETURNTRANSFER, true);
			$c->setopt(CURLOPT_FOLLOWLOCATION, true);
		$c->setopt(CURLOPT_HEADER, true);
		$c->setopt(CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
		$c->setopt(CURLOPT_USERPWD, $this->accountSid.":".$this->authToken);
		$c->setopt(CURLOPT_POST, true);
		$c->setopt(CURLOPT_POSTFIELDS, $data);
			
		$resultVal = $c->exec();
		$resultVal = trim($resultVal);
		
		$error = "";		
		if ($theError = $c->hasError())
		{
		 echo $error = "ERROR :".$theError ;
		}
				
		$statusArr =  $c->getStatus();
		$http_code = $statusArr['http_code'];
		
		$retArray = $this->xml2array($resultVal);
		
		return $retArray;
				
	}
	
	

	function xml2array($contents, $get_attributes=1, $priority = 'tag') 
	{ 
		if(!$contents) return array(); 
	
		if(!function_exists('xml_parser_create')) { 
			//print "'xml_parser_create()' function not found!"; 
			return array(); 
		} 

		//Get the XML parser of PHP - PHP must have this module for the parser to work 
		$parser = xml_parser_create(''); 
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");  
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
		xml_parse_into_struct($parser, trim($contents), $xml_values); 
		xml_parser_free($parser); 

		if(!$xml_values) return;//Hmm... 
	
		//Initializations 
		$xml_array = array(); 
		$parents = array(); 
		$opened_tags = array(); 
		$arr = array(); 

		$current = &$xml_array; //Refference 
	
		//Go through the tags. 
		$repeated_tag_index = array();//Multiple tags with same name will be turned into an array 
		foreach($xml_values as $data) { 
			unset($attributes,$value);//Remove existing values, or there will be trouble 
	
			//This command will extract these variables into the foreach scope 
			// tag(string), type(string), level(int), attributes(array). 
			extract($data);//We could use the array by itself, but this cooler. 

			$result = array(); 
			$attributes_data = array(); 
			 
			if(isset($value)) { 
				if($priority == 'tag') $result = $value; 
				else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode 
			} 
	
			//Set the attributes too. 
			if(isset($attributes) and $get_attributes) { 
				foreach($attributes as $attr => $val) { 
					if($priority == 'tag') $attributes_data[$attr] = $val; 
					else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr' 
				} 
			} 
	
			//See tag status and do the needed. 
			if($type == "open") {//The starting of the tag '<tag>' 
				$parent[$level-1] = &$current; 
				if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag 
					$current[$tag] = $result; 
					if($attributes_data) $current[$tag. '_attr'] = $attributes_data; 
					$repeated_tag_index[$tag.'_'.$level] = 1; 
	
					$current = &$current[$tag]; 
	
				} else { //There was another element with the same tag name 

					if(isset($current[$tag][0])) {//If there is a 0th element it is already an array 
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
						$repeated_tag_index[$tag.'_'.$level]++; 
					} else {//This section will make the value an array if multiple tags with the same name appear together
						$current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
						$repeated_tag_index[$tag.'_'.$level] = 2; 
						 
						if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
							$current[$tag]['0_attr'] = $current[$tag.'_attr']; 
							unset($current[$tag.'_attr']); 
						} 
	
					} 
					$last_item_index = $repeated_tag_index[$tag.'_'.$level]-1; 
					$current = &$current[$tag][$last_item_index]; 
				} 
	
			} elseif($type == "complete") { //Tags that ends in 1 line '<tag />' 
				//See if the key is already taken. 
				if(!isset($current[$tag])) { //New Key 
					$current[$tag] = $result; 
					$repeated_tag_index[$tag.'_'.$level] = 1; 
					if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data; 
	
				} else { //If taken, put all things inside a list(array) 
					if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array... 
	
						// ...push the new element into that array. 
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
						 
						if($priority == 'tag' and $get_attributes and $attributes_data) { 
							$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
						} 
						$repeated_tag_index[$tag.'_'.$level]++; 
	
					} else { //If it is not an array... 
						$current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
						$repeated_tag_index[$tag.'_'.$level] = 1; 
						if($priority == 'tag' and $get_attributes) { 
							if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
								 
								$current[$tag]['0_attr'] = $current[$tag.'_attr']; 
								unset($current[$tag.'_attr']); 
							} 
							 
							if($attributes_data) { 
								$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
							} 
						} 
						$repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken 
					} 
				} 
	
			} elseif($type == 'close') { //End of tag '</tag>' 
				$current = &$parent[$level-1]; 
			} 
		} 
     
    return($xml_array); 
	}
}