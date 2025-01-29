<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CdrController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        // Load the user model
        $this->userModel = model('User Model');
    }

    public function index()
    {
        $flag = $this->request->getVar('flag') ?? "MySQL"; 
        $perPage = 5;
        $currentPage = $this->request->getVar('page') ?? 1; // Default to page 1
        $url = "";

        // Set the URL for the cURL request based on the flag
        if ($flag == "MySQL") {
            $url = "http://localhost:3000/mysql/get/";
        } elseif ($flag == "MongoDB") {
            $url = "http://localhost:3001/mongodb/get/";
        } elseif ($flag == "Elastic") {
            $url = "http://localhost:9200/elasticReport/get";
        } else {
            return $this->response->setJSON(['error' => 'Invalid flag value']);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request and store the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            return $this->response->setJSON(['error' => curl_error($ch)]);
        }
        curl_close($ch);

        // Decode the API response
        $data = json_decode($response, true);

        $pager = \Config\Services::pager();
        $totalRecords = count($data);
        $reports = array_slice($data, ($currentPage - 1) * $perPage, $perPage);
        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $totalRecords);

        // Prepare data for the view
        $viewData = [
            'cdrData' => $reports,
            'pager' => $pagerLinks,
            'totalRecords' => $totalRecords,
            'currentPage' => $currentPage,
            'flag' => $flag 
        ];

        return view('/reports/cdr_report', $viewData);
    }

    public function downloadCDRCSV()
    {
        $flag = $this->request->getVar('flag') ?? "MySQL"; // Get the flag from the request
        $client = \Config\Services::curlrequest();
        
        // Set the API URL based on the flag
        if ($flag == "MySQL") {
            $apiUrl = 'http://localhost:3000/mysql/get/';
            $filename = 'MySQL_Report.csv';
        } elseif ($flag == "MongoDB") {
            $apiUrl = 'http://localhost:3001/mongodb/get/';
            $filename = 'MongoDB_Report.csv';
        } elseif ($flag == "Elastic") {
            $apiUrl = 'http://localhost:9200/elasticReport/get';
            $filename = 'Elasticsearch_Report.csv';
        } else {
            return $this->response->setJSON(['message' => 'Invalid flag']);
        }

        try {
            // Make the API request
            $response = $client->request('GET', $apiUrl);
            $data = json_decode($response->getBody(), true);

            // Log the response for debugging
            log_message('info', 'API Response for flag ' . $flag . ': ' . print_r($data, true));

            // Prepare CSV header
            $csvData = "agentName,campaignName,processName,initiatedTime,reportType,disposeType,disposeName,leadset,referenceUuid,custumerUuid,hold,mute,ringing,txTime,conference,talktime,disposeTime,duration\n";

            // Determine the data structure and prepare CSV accordingly
            if (is_array($data)) {
                foreach ($data as $row) {
                    $csvData .= implode(',', [
                        $row['agentName'],
                        $row['campaignName'],
                        $row['processName'],
                        $row['initiatedTime'],
                        $row['reportType'],
                        $row['disposeType'],
                        $row['disposeName'],
                        $row['leadset'],
                        $row['referenceUuid'],
                        $row['custumerUuid'],
                        gmdate("H:i:s",$row['hold']),
                        gmdate("H:i:s",$row['mute']),
                        gmdate("H:i:s",$row['ringing']),
                        gmdate("H:i:s",$row['txTime']),
                        gmdate("H:i:s",$row['conference']),
                        gmdate("H:i:s",$row['talktime']),
                        $row['disposeTime'],
                        gmdate("H:i:s",$row['duration'])
                    ]) . "\n";
                }
            } 

            // Set headers for download
            $this->response->setHeader('Content-Type', 'text/csv');
            $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
            $this->response->setBody($csvData);

            return $this->response;
        } catch (\Exception $e) {
            log_message('error', 'Error fetching data: ' . $e->getMessage());
            return $this->response->setJSON(['message' => 'Error fetching data']);
        }
    }

    public function summary(){
        $flag = $this->request->getVar('flag') ?? "MySQL";
        $perPage = 5;
        $currentPage = $this->request->getVar('page') ?? 1; // Default to page 1
        $url = "";

        // Set the URL for the cURL request based on the flag
        if ($flag == "MySQL") {
            $url = "http://localhost:3000/mysql/hourlyReport";
        } elseif ($flag == "MongoDB") {
            $url = "http://localhost:3001/mongodb/hourlyReport";
        } elseif ($flag == "Elastic") {
            $url = "http://localhost:9200/elasticsearch/hourlyReport";
        } else {
            return $this->response->setJSON(['error' => 'Invalid flag value']);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute the cURL request and store the response
        $response = curl_exec($ch);
    
        // Check for cURL errors
        if (curl_errno($ch)) {
            return $this->response->setJSON(['error' => curl_error($ch)]);
        }
        curl_close($ch);
    
        // Decode the API response
        $data = json_decode($response, true);
    
        // Create pagination links
        $pager = \Config\Services::pager();
        $totalRecords = count($data);
        $reports = array_slice($data, ($currentPage - 1) * $perPage, $perPage);
        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $totalRecords);

        // Prepare data for the view
        $viewData = [
            'summary' => $reports, 
            'pager' => $pagerLinks,
            'totalRecords' => $totalRecords,
            'currentPage' => $currentPage,
            'flag' => $flag 
        ];
    
        return view('/reports/summary_report', $viewData);
    }

    public function downloadSummaryCSV()
    {
        $flag = $this->request->getVar('flag') ?? "MySQL"; // Get the flag from the request
        $client = \Config\Services::curlrequest();
        
        // Set the API URL based on the flag
        if ($flag == "MySQL") {
            $apiUrl = 'http://localhost:3000/mysql/hourlyReport';
            $filename = 'MySQL_Summary.csv';
        } elseif ($flag == "MongoDB") {
            $apiUrl = 'http://localhost:3001/mongodb/hourlyReport';
            $filename = 'MongoDB_Summary.csv';
        } elseif ($flag == "Elastic") {
            $apiUrl = 'http://localhost:9200/elasticsearch/hourlyReport';
            $filename = 'Elasticsearch_Summary.csv';
        } else {
            return $this->response->setJSON(['message' => 'Invalid flag']);
        }

        try {
            // Make the API request
            $response = $client->request('GET', $apiUrl);
            $data = json_decode($response->getBody(), true);

           // Log the response for debugging
           log_message('info', 'API Response for flag ' . $flag . ': ' . print_r($data, true));  

            // Prepare CSV header
            $csvData = "Hour,Agent Name,Campaign Name, Process Name Dispose Type, Total Ringing Time, Total Hold Time,Total Talk Time,Total Duration,Total Mute Time,Total Transfer Time,Total Conference Time,Total Duration,\n";

            // Loop through the report data and append to CSV
            foreach ($data as $row) {
                $csvData .= implode(',', [
                    $row['hour'],
                    $row['agentName'],
                    $row['campaignName'],
                    $row['processName'],
                    $row['disposeType'],
                    $row['totalRingingTime'],
                    $row['totalHoldTime'],
                    $row['totalTalkTime'],
                    $row['totalMuteTime'],
                    $row['totalTransferTime'],
                    $row['totalConferenceTime'],
                    $row['totalDuration'],
                ]) . "\n";
            }

            // Set headers for download
            $this->response->setHeader('Content-Type', 'text/csv');
            $this->response->setHeader('Content-Disposition', 'attachment; filename=""' . $filename . '"');
            $this->response->setBody($csvData);

            return $this->response;
        } catch (\Exception $e) {
            log_message('error', 'Error fetching data: ' . $e->getMessage());
            return $this->response->setJSON(['message' => 'Error fetching data']);
        }
    }

    public function filter()
    {
        $databaseOptions = $this->request->getVar('databaseOptions'); 
        $perPage = 5;
        $currentPage = $this->request->getVar('page') ?? 1;        
        $filterName = $this->request->getVar('filterName');
        $typeOptions = $this->request->getVar('typeOptions'); 
        $disposeTypeOptions = $this->request->getVar('disposeTypeOptions'); 
    
        
        if ($databaseOptions === 'mysql') {
            $flag = 1;
            $url = "http://localhost:3000/mysql/filter"; 
        } elseif ($databaseOptions === 'mongo') {
            $flag = 2;
            $url = "http://localhost:3001/mongodb/filter"; 
        } elseif ($databaseOptions === 'elastic') {
            $flag = 3;
            $url = "http://localhost:9200/elasticsearch/filter"; 
        } else {
            return $this->response->setJSON(['error' => 'Invalid database selection']);
        }
    
        $postData = [
            'typeOptions' => $typeOptions,
            'filterName' => $filterName,
            'disposeTypeOptions' => $disposeTypeOptions
        ];
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData)); 
    
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            return $this->response->setJSON(['error' => curl_error($ch)]);
        }
        curl_close($ch);
    
        $data = json_decode($response, true);
    

        $pager = \Config\Services::pager();
        $totalRecords = count($data);
        $reports = array_slice($data, ($currentPage - 1) * $perPage, $perPage);
        

        $pagerLinks = $pager->makeLinks($currentPage, $perPage, $totalRecords);
    

        $viewData = [
            'cdrData' => $reports,
            'pager' => $pagerLinks,
            'totalRecords' => $totalRecords,
            'currentPage' => $currentPage,
            'flag' => $flag 
        ];
    
        return view('/reports/cdr_report', $viewData);
    }
}
