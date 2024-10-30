<?php 


class ChromeNotify
{
    protected $apiKey;

    protected $ids = array();


    public function notify()
    {

        $this->sendGCM();

    }

    public function setData($data)
    {
        $this->data = $data;
    }


    public function setIds($ids)
    {
        $this->ids = $ids;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getIds()
    {
        return $this->ids;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }
    private function sendGCM()
    {   
        //Let's get all the important info from our setters
        $data = $this->getData();//Data we're sending out to the customer
        $ids = $this->getIds();//Ids of the people receiving a given message
        $apiKey = $this->getApiKey();//Our api key, taken from https://code.google.com/apis/console/

      

        $url = 'https://android.googleapis.com/gcm/send'; //That's where the we 
// send the message to, so that Google can relay it to the right person



        $post = array(
                        'registration_ids'  => $ids,
                        'data'              => $data,
                        );

        $headers = array( 
                            'Authorization: key=' . $apiKey,
                            'Content-Type: application/json'
                        );

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );
        $this->result = curl_exec( $ch );

        
        if ( curl_errno( $ch ) )
        {
            echo 'GCM error: ' . curl_error( $ch );
        }

        

        curl_close( $ch );

       

        }

}