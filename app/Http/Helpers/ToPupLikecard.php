<?php


  function toPup($phone,$amount){
        $curl = curl_init();
        $time= \Carbon\Carbon::now()->timestamp;
        $hash = $time;

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://taxes.like4app.com/online/create_order",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'deviceId' => 'b42bdde70294758891a6590127ec802d37e9e1ee0473c45ee86bd14a1db35cda',
                'email' => '3lialmuslem@gmail.com',
                'password' => '18c5fd46f0d3ba3929b88feb9e1c4ebe8cd66a5db9a5dd3363f991c727530e5917b96f86a92c4742e9ce77c8a6cf59ec',
                'securityCode' => 'e8f8aca5140c40104f2ccdaf8909953d8f5184e66a43a6d04765fded11afe8e6',
                'langId' => '1',
                'phone'=>$phone,
                'skuCode' => "mobilyDirectTopUp",
                'receiveAmount' => $amount,
                'referenceId' => 'Merchant_12467',
                'time' => $time,
                'hash' => generateHash($hash),
            ),

        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response);
        dd($data);

    }

