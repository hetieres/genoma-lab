<?php
namespace App\Helpers;

class FapespHelper {
    protected $_fapesp = 'http://fapesp.br/';
    protected $_url    = 'http://fapesp.br/.design/api/';

    public function __construct() {
        $this->_api = '';
    }

    public function getData($method, $params=[])
    {
        $gets     = $this->_treatsParams($params);
        $dataStr  = $this->_getDataApi($this->_url . $method . $gets);

        // $dataStr  = file_get_contents($this->_url . $method . $gets);
        // $response = $this->_treatsHeader($http_response_header);
        // $code     = (isset($response->http->code) ? (int) $response->http->code: null);

        $data     = ($dataStr->code === 200 ? $dataStr->resp : []);

        return $data;
    }

    private function _treatsParams($params)
    {
        $return = '';

        if (count($params)>0) {
            foreach ($params as $key => $value) {
                $return .= ($return!=='' ? '&' : '') . $key . '=' . $value;
            }
        }

        return ($return!=='' ? '?' : '') . $return;
    }

    private function _treatsHeader($response)
    {
        $return   = array();
        $httpResp = array();
        $httpBase = explode(' ', $response[0]);

        $httpResp['type'] = trim($httpBase[0]);
        unset($httpBase[0]);

        $httpResp['code'] = trim($httpBase[1]);
        unset($httpBase[1]);

        $httpResp['message'] = trim(implode(' ', $httpBase));
        $return['http'] = (object) $httpResp;

        // Remove http item of array
        unset($response[0]);

        foreach ($response as $item) {
            $base  = explode(': ', $item);
            $key   = trim($base[0]);
            $value = trim($base[1]);

            $return[$key] = $value;
        }

        return (object) $return;
    }

    private function _getDataApi($url)
    {
        $return = [];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ]);

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        $code     = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $return['code'] = $code;
        $return['resp'] = json_decode($response);

        return (object) $return;
    }
}