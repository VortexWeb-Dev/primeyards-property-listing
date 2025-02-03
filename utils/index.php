<?php

require_once(__DIR__ . "/../crest/crest.php");
require_once(__DIR__ . "/../crest/crestcurrent.php");


function buildApiUrl($baseUrl, $entityTypeId, $fields, $start = 0)
{
    $selectParams = '';
    foreach ($fields as $index => $field) {
        $selectParams .= "select[$index]=$field&";
    }
    $selectParams = rtrim($selectParams, '&');
    return "$baseUrl/crm.item.list?entityTypeId=$entityTypeId&$selectParams&start=$start&filter[ufCrm14Status]=PUBLISHED";
}

function fetchAllProperties($baseUrl, $entityTypeId, $fields, $platform = null)
{
    $allProperties = [];
    $start = 0;

    try {
        while (true) {
            $apiUrl = buildApiUrl($baseUrl, $entityTypeId, $fields, $start);
            $response = file_get_contents($apiUrl);
            $data = json_decode($response, true);

            if (isset($data['result']['items'])) {
                $properties = $data['result']['items'];
                $allProperties = array_merge($allProperties, $properties);
            }

            // If there's no "next" key, we've fetched all data
            if (empty($data['next'])) {
                break;
            }

            $start = $data['next'];
        }

        if ($platform) {
            switch ($platform) {
                case 'pf':
                    $allProperties = array_filter($allProperties, function ($property) {
                        return $property['ufCrm14PfEnable'] === 'Y';
                    });
                    break;
                case 'bayut':
                    $allProperties = array_filter($allProperties, function ($property) {
                        return $property['ufCrm14BayutEnable'] === 'Y';
                    });
                    break;
                case 'dubizzle':
                    $allProperties = array_filter($allProperties, function ($property) {
                        return $property['ufCrm14DubizzleEnable'] === 'Y';
                    });
                    break;
                case 'website':
                    $allProperties = array_filter($allProperties, function ($property) {
                        return $property['ufCrm14WebsiteEnable'] === 'Y';
                    });
                    break;
                default:
                    break;
            }
        }

        return $allProperties;
    } catch (Exception $e) {
        error_log('Error fetching properties: ' . $e->getMessage());
        return [];
    }
}

function getPropertyPurpose($property)
{
    return ($property['ufCrm14OfferingType'] == 'RR' || $property['ufCrm14OfferingType'] == 'CR') ? 'Rent' : 'Buy';
}

function getPropertyType($property)
{
    $property_types = array(
        "AP" => "Apartment",
        "BW" => "Bungalow",
        "CD" => "Compound",
        "DX" => "Duplex",
        "FF" => "Full floor",
        "HF" => "Half floor",
        "LP" => "Land / Plot",
        "PH" => "Penthouse",
        "TH" => "Townhouse",
        "VH" => "Villa",
        "WB" => "Whole Building",
        "HA" => "Short Term / Hotel Apartment",
        "LC" => "Labor camp",
        "BU" => "Bulk units",
        "WH" => "Warehouse",
        "FA" => "Factory",
        "OF" => "Office space",
        "RE" => "Retail",
        "LP" => "Plot",
        "SH" => "Shop",
        "SR" => "Show Room",
        "SA" => "Staff Accommodation"
    );

    return $property_types[$property['ufCrm14PropertyType']] ?? '';
}

function getPermitNumber($property)
{
    if (!empty($property['ufCrm14PermitNumber'])) {
        return $property['ufCrm14PermitNumber'];
    }
    return $property['ufCrm14ReraPermitNumber'] ?? '';
}

function getFullAmenityName($shortCode)
{
    $amenityMap = [
        'BA' => 'Balcony',
        'BP' => 'Basement parking',
        'BB' => 'BBQ area',
        'AN' => 'Cable-ready',
        'BW' => 'Built in wardrobes',
        'CA' => 'Carpets',
        'AC' => 'Central air conditioning',
        'CP' => 'Covered parking',
        'DR' => 'Drivers room',
        'FF' => 'Fully fitted kitchen',
        'GZ' => 'Gazebo',
        'PY' => 'Private Gym',
        'PJ' => 'Jacuzzi',
        'BK' => 'Kitchen Appliances',
        'MR' => 'Maids Room',
        'MB' => 'Marble floors',
        'HF' => 'On high floor',
        'LF' => 'On low floor',
        'MF' => 'On mid floor',
        'PA' => 'Pets allowed',
        'GA' => 'Private garage',
        'PG' => 'Garden',
        'PP' => 'Swimming pool',
        'SA' => 'Sauna',
        'SP' => 'Shared swimming pool',
        'WF' => 'Wood flooring',
        'SR' => 'Steam room',
        'ST' => 'Study',
        'UI' => 'Upgraded interior',
        'GR' => 'Garden view',
        'VW' => 'Sea/Water view',
        'SE' => 'Security',
        'MT' => 'Maintenance',
        'IC' => 'Within a Compound',
        'IS' => 'Indoor swimming pool',
        'SF' => 'Separate entrance for females',
        'BT' => 'Basement',
        'SG' => 'Storage room',
        'CV' => 'Community view',
        'GV' => 'Golf view',
        'CW' => 'City view',
        'NO' => 'North orientation',
        'SO' => 'South orientation',
        'EO' => 'East orientation',
        'WO' => 'West orientation',
        'NS' => 'Near school',
        'HO' => 'Near hospital',
        'TR' => 'Terrace',
        'NM' => 'Near mosque',
        'SM' => 'Near supermarket',
        'ML' => 'Near mall',
        'PT' => 'Near public transportation',
        'MO' => 'Near metro',
        'VT' => 'Near veterinary',
        'BC' => 'Beach access',
        'PK' => 'Public parks',
        'RT' => 'Near restaurants',
        'NG' => 'Near Golf',
        'AP' => 'Near airport',
        'CS' => 'Concierge Service',
        'SS' => 'Spa',
        'SY' => 'Shared Gym',
        'MS' => 'Maid Service',
        'WC' => 'Walk-in Closet',
        'HT' => 'Heating',
        'GF' => 'Ground floor',
        'SV' => 'Server room',
        'DN' => 'Pantry',
        'RA' => 'Reception area',
        'VP' => 'Visitors parking',
        'OP' => 'Office partitions',
        'SH' => 'Core and Shell',
        'CD' => 'Children daycare',
        'CL' => 'Cleaning services',
        'NH' => 'Near Hotel',
        'CR' => 'Conference room',
        'BL' => 'View of Landmark',
        'PR' => 'Children Play Area',
        'BH' => 'Beach Access'
    ];

    return $amenityMap[$shortCode] ?? $shortCode;
}

function formatDate($date)
{
    return $date ? date('Y-m-d H:i:s', strtotime($date)) : date('Y-m-d H:i:s');
}

function formatField($field, $value, $type = 'string')
{
    if (empty($value) && $value != 0) {
        return '';
    }

    switch ($type) {
        case 'date':
            return '<' . $field . '>' . formatDate($value) . '</' . $field . '>';
        default:
            return '<' . $field . '>' . htmlspecialchars($value) . '</' . $field . '>';
    }
}

function formatPriceOnApplication($property)
{
    $priceOnApplication = ($property['ufCrm14HidePrice'] === 'Y') ? 'Yes' : 'No';
    return formatField('price_on_application', $priceOnApplication);
}

function formatRentalPrice($property)
{
    if (empty($property['ufCrm14RentalPeriod'])) {
        return formatField('price', $property['ufCrm14Price']);
    }

    switch ($property['ufCrm14RentalPeriod']) {
        case 'Y':
            return formatField('price', $property['ufCrm14Price'], 'yearly');
        case 'M':
            return formatField('price', $property['ufCrm14Price'], 'monthly');
        case 'W':
            return formatField('price', $property['ufCrm14Price'], 'weekly');
        case 'D':
            return formatField('price', $property['ufCrm14Price'], 'daily');
        default:
            return formatField('price', $property['ufCrm14Price']);
    }
}

function formatBedroom($property)
{
    return formatField('bedroom', ($property['ufCrm14Bedroom'] > 7) ? '7+' : $property['ufCrm14Bedroom']);
}

function formatBathroom($property)
{
    return formatField('bathroom', ($property['ufCrm14Bathroom'] > 7) ? '7+' : $property['ufCrm14Bathroom']);
}

function formatFurnished($property)
{
    $furnished = $property['ufCrm14Furnished'] ?? '';
    if ($furnished) {
        switch ($furnished) {
            case 'furnished':
                return formatField('furnished', 'Yes');
            case 'unfurnished':
                return formatField('furnished', 'No');
            case 'Partly Furnished':
                return formatField('semi-furnished', 'Partly');
            default:
                return '';
        }
    }
    return ''; // If no furnished value exists, return an empty string
}

function formatAgent($property)
{
    $xml = '<agent>';
    $xml .= formatField('id', $property['ufCrm14AgentId']);
    $xml .= formatField('name', $property['ufCrm14AgentName']);
    $xml .= formatField('email', $property['ufCrm14AgentEmail']);
    $xml .= formatField('phone', $property['ufCrm14AgentPhone']);
    $xml .= formatField('photo', $property['ufCrm14AgentPhoto'] ?? 'https://youtupia.com/thinkrealty/images/agent-placeholder.webp');
    $xml .= '</agent>';

    return $xml;
}

function formatPhotos($photos)
{
    if (empty($photos)) {
        return '';
    }

    $xml = '<photo>';
    foreach ($photos as $photo) {
        $xml .= '<url last_update="' . date('Y-m-d H:i:s') . '" watermark="Yes">' . htmlspecialchars($photo) . '</url>';
    }
    $xml .= '</photo>';

    return $xml;
}

function formatGeopoints($property)
{
    $geopoints = "";

    if (!empty($property['ufCrm14Latitude']) && !empty($property['ufCrm14Longitude'])) {
        $geopoints = ($property['ufCrm14Latitude'] . ',' . $property['ufCrm14Longitude'] ?? '');
    } else {
        $geopoints = ($property['ufCrm14Geopoints'] ?? '');
    }

    return formatField('geopoints', $geopoints);
}

function formatCompletionStatus($property)
{
    $status = $property['ufCrm14ProjectStatus'] ?? '';
    switch ($status) {
        case 'Completed':
        case 'ready_secondary':
            return formatField('completion_status', 'completed');
        case 'offplan':
        case 'offplan_secondary':
            return formatField('completion_status', 'off_plan');
        case 'ready_primary':
            return formatField('completion_status', 'completed_primary');
        case 'offplan_primary':
            return formatField('completion_status', 'off_plan_primary');
        default:
            return '';
    }
}

function generatePfXml($properties)
{
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<list last_update="' . date('Y-m-d H:i:s') . '" listing_count="' . count($properties) . '">';

    foreach ($properties as $property) {
        $xml .= '<property last_update="' . formatDate($property['updatedTime'] ?? '') . '" id="' . htmlspecialchars($property['id'] ?? '') . '">';

        $xml .= formatField('reference_number', $property['ufCrm14ReferenceNumber']);
        $xml .= formatField('permit_number', getPermitNumber($property));

        $xml .= formatField('dtcm_permit', $property['ufCrm14DtcmPermitNumber']);
        $xml .= formatField('offering_type', $property['ufCrm14OfferingType']);
        $xml .= formatField('property_type', $property['ufCrm14PropertyType']);
        $xml .= formatPriceOnApplication($property);
        $xml .= formatRentalPrice($property);

        $xml .= formatField('service_charge', $property['ufCrm14ServiceCharge']);
        $xml .= formatField('cheques', $property['ufCrm14NoOfCheques']);
        $xml .= formatField('city', $property['ufCrm14City']);
        $xml .= formatField('community', $property['ufCrm14Community']);
        $xml .= formatField('sub_community', $property['ufCrm14SubCommunity']);
        $xml .= formatField('property_name', $property['ufCrm14Tower']);

        $xml .= formatField('title_en', $property['ufCrm14TitleEn']);
        $xml .= formatField('title_ar', $property['ufCrm14TitleAr']);
        $xml .= formatField('description_en', $property['ufCrm14DescriptionEn']);
        $xml .= formatField('description_ar', $property['ufCrm14DescriptionAr']);

        $xml .= formatField('plot_size', $property['ufCrm14TotalPlotSize']);
        $xml .= formatField('size', $property['ufCrm14Size']);
        // $xml .= formatField('bedroom', $property['ufCrm14Bedroom']);
        $xml .= formatBedroom($property);
        $xml .= formatBathroom($property);

        $xml .= formatAgent($property);
        $xml .= formatField('build_year', $property['ufCrm14BuildYear']);
        $xml .= formatField('parking', $property['ufCrm14Parking']);
        $xml .= formatFurnished($property);
        $xml .= formatField('view360', $property['ufCrm_14_360_VIEW_URL']);
        $xml .= formatPhotos($property['ufCrm14PhotoLinks']);
        $xml .= formatField('floor_plan', $property['ufCrm14FloorPlan']);
        $xml .= formatGeopoints($property);
        $xml .= formatField('availability_date', $property['ufCrm14AvailableFrom'], 'date');
        $xml .= formatField('video_tour_url', $property['ufCrm14VideoTourUrl']);
        $xml .= formatField('developer', $property['ufCrm14Developers']);
        $xml .= formatField('project_name', $property['ufCrm14ProjectName']);
        $xml .= formatCompletionStatus($property);

        $xml .= '</property>';
    }

    $xml .= '</list>';
    return $xml;
}

function generateBayutXml($properties)
{
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<Properties last_update="' . date('Y-m-d H:i:s') . '" listing_count="' . count($properties) . '">';

    foreach ($properties as $property) {
        $xml .= '<Property id="' . htmlspecialchars($property['id'] ?? '') . '">';

        // Ensure proper CDATA wrapping and no misplaced closing tags
        $xml .= '<Property_Ref_No><![CDATA[' . ($property['ufCrm14ReferenceNumber'] ?? '') . ']]></Property_Ref_No>';
        $xml .= '<Permit_Number><![CDATA[' . getPermitNumber($property) . ']]></Permit_Number>';
        $xml .= '<Property_Status>live</Property_Status>';
        $xml .= '<Property_purpose><![CDATA[' . getPropertyPurpose($property) . ']]></Property_purpose>';
        $xml .= '<Property_Type><![CDATA[' . getPropertyType($property) . ']]></Property_Type>';
        $xml .= '<Property_Size><![CDATA[' . ($property['ufCrm14Size'] ?? '') . ']]></Property_Size>';
        $xml .= '<Property_Size_Unit>SQFT</Property_Size_Unit>';

        // Ensure proper condition for optional fields
        if (!empty($property['ufCrm14TotalPlotSize'])) {
            $xml .= '<plotArea><![CDATA[' . $property['ufCrm14TotalPlotSize'] . ']]></plotArea>';
        }

        $xml .= '<Bedrooms><![CDATA[' . (($property['ufCrm14Bedroom'] === 0) ? -1 : ($property['ufCrm14Bedroom'] > 10 ? "10+" : $property['ufCrm14Bedroom'])) . ']]></Bedrooms>';
        $xml .= '<Bathrooms><![CDATA[' . ($property['ufCrm14Bathroom'] ?? '') . ']]></Bathrooms>';

        $is_offplan = ($property['ufCrm14ProjectStatus'] === 'offplan_primary' || $property['ufCrm14ProjectStatus'] === 'offplan_secondary') ? 'Yes' : 'No';
        $xml .= '<Off_plan><![CDATA[' . $is_offplan . ']]></Off_plan>';

        $xml .= '<Portals>';
        if ($property['ufCrm14BayutEnable'] === 'Y') {
            $xml .= '<Portal>Bayut</Portal>';
        }
        if ($property['ufCrm14DubizzleEnable'] === 'Y') {
            $xml .= '<Portal>Dubizzle</Portal>';
        }
        $xml .= '</Portals>';

        $xml .= '<Property_Title><![CDATA[' . ($property['ufCrm14TitleEn'] ?? '') . ']]></Property_Title>';
        $xml .= '<Property_Description><![CDATA[' . ($property['ufCrm14DescriptionEn'] ?? '') . ']]></Property_Description>';

        if (!empty($property['ufCrm14TitleAr'])) {
            $xml .= '<Property_Title_AR><![CDATA[' . ($property['ufCrm14TitleAr'] ?? '') . ']]></Property_Title_AR>';
        }
        if (!empty($property['ufCrm14DescriptionAr'])) {
            $xml .= '<Property_Description_AR><![CDATA[' . ($property['ufCrm14DescriptionAr'] ?? '') . ']]></Property_Description_AR>';
        }

        $xml .= '<Price><![CDATA[' . ($property['ufCrm14Price'] ?? '') . ']]></Price>';

        if ($property['ufCrm14RentalPeriod'] == 'Y') {
            $xml .= '<Rent_Frequency>Yearly</Rent_Frequency>';
        } elseif ($property['ufCrm14RentalPeriod'] == 'M') {
            $xml .= '<Rent_Frequency>Monthly</Rent_Frequency>';
        } elseif ($property['ufCrm14RentalPeriod'] == 'W') {
            $xml .= '<Rent_Frequency>Weekly</Rent_Frequency>';
        } elseif ($property['ufCrm14RentalPeriod'] == 'D') {
            $xml .= '<Rent_Frequency>Daily</Rent_Frequency>';
        }

        if ($property['ufCrm14Furnished'] === 'furnished') {
            $xml .= '<Furnished>Yes</Furnished>';
        } elseif ($property['ufCrm14Furnished'] === 'unfurnished') {
            $xml .= '<Furnished>No</Furnished>';
        } elseif ($property['ufCrm14Furnished'] === 'semi-furnished') {
            $xml .= '<Furnished>Partly</Furnished>';
        }

        if (!empty($property['ufCrm14SaleType'])) {
            $xml .= '<offplanDetails_saleType><![CDATA[' . ($property['ufCrm14SaleType'] ?? '') . ']]></offplanDetails_saleType>';
        }

        $xml .= '<City><![CDATA[' . ($property['ufCrm14BayutCity'] ?: $property['ufCrm14City'] ?? '') . ']]></City>';
        $xml .= '<Locality><![CDATA[' . ($property['ufCrm14BayutCommunity'] ?: $property['ufCrm14Community'] ?? '') . ']]></Locality>';
        $xml .= '<Sub_Locality><![CDATA[' . ($property['ufCrm14BayutSubCommunity'] ?: $property['ufCrm14SubCommunity'] ?? '') . ']]></Sub_Locality>';
        $xml .= '<Tower_Name><![CDATA[' . ($property['ufCrm14BayutTower'] ?: $property['ufCrm14Tower'] ?? '') . ']]></Tower_Name>';

        $xml .= '<Listing_Agent><![CDATA[' . ($property['ufCrm14AgentName'] ?? '') . ']]></Listing_Agent>';
        $xml .= '<Listing_Agent_Phone><![CDATA[' . ($property['ufCrm14AgentPhone'] ?? '') . ']]></Listing_Agent_Phone>';
        $xml .= '<Listing_Agent_Email><![CDATA[' . ($property['ufCrm14AgentEmail'] ?? '') . ']]></Listing_Agent_Email>';

        $xml .= '<Images>';
        foreach ($property['ufCrm14PhotoLinks'] ?? [] as $image) {
            $xml .= '<Image last_update="' . date('Y-m-d H:i:s') . '"><![CDATA[' . $image . ']]></Image>';
        }
        $xml .= '</Images>';

        if (!empty($property['ufCrm14Amenities']) && is_array($property['ufCrm14Amenities'])) {
            $xml .= '<Features>';
            foreach ($property['ufCrm14Amenities'] as $amenity) {
                $fullName = getFullAmenityName(trim($amenity));
                $xml .= '<Feature><![CDATA[' . $fullName . ']]></Feature>';
            }
            $xml .= '</Features>';
        }

        $xml .= '</Property>';
    }

    $xml .= '</Properties>';
    return $xml;
}

function uploadFile($file, $isDocument = false)
{
    global $cloudinary;

    try {
        if (!file_exists($file)) {
            throw new Exception("File not found: " . $file);
        }

        $uploadResponse = $cloudinary->uploadApi()->upload($file, [
            'folder' => 'primeyards-uploads',
            'resource_type' => $isDocument ? 'raw' : 'image',
        ]);

        return $uploadResponse['secure_url'];
    } catch (Exception $e) {
        error_log("Error uploading image: " . $e->getMessage());
        echo "Error uploading image: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        return false;
    }
}

function fetchCurrentUser()
{
    $response = CRestCurrent::call("user.current");
    return $response['result'];
}

function isAdmin($userId)
{
    $response = CRestCurrent::call("user.admin");

    $admins = [
        8, // VortexWeb
    ];

    return true || in_array($userId, $admins);
}


function generateWebsiteJson($properties)
{
    $json = json_encode([
        'properties' => $properties,
        'total' => count($properties)
    ]);

    return $json;
}
