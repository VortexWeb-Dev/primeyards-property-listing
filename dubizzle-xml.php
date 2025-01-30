<?php
require 'utils/index.php';

header('Content-Type: application/xml; charset=UTF-8');

$baseUrl = 'https://primeyards.bitrix24.com/rest/8/pgu3tj84jm1lyk1z';
$entityTypeId = 1052;
$fields = [
    'id',
    'ufCrm14ReferenceNumber',
    'ufCrm14PermitNumber',
    'ufCrm14ReraPermitNumber',
    'ufCrm14DtcmPermitNumber',
    'ufCrm14OfferingType',
    'ufCrm14PropertyType',
    'ufCrm14HidePrice',
    'ufCrm14RentalPeriod',
    'ufCrm14YearlyPrice',
    'ufCrm14MonthlyPrice',
    'ufCrm14WeeklyPrice',
    'ufCrm14DailyPrice',
    'ufCrm14Price',
    'ufCrm14ServiceCharge',
    'ufCrm14NoOfCheques',
    'ufCrm14City',
    'ufCrm14Community',
    'ufCrm14SubCommunity',
    'ufCrm14Tower',
    'ufCrm14BayutCity',
    'ufCrm14BayutCommunity',
    'ufCrm14BayutSubCommunity',
    'ufCrm14BayutTower',
    'ufCrm14TitleEn',
    'ufCrm14TitleAr',
    'ufCrm14DescriptionEn',
    'ufCrm14DescriptionAr',
    'ufCrm14TotalPlotSize',
    'ufCrm14Size',
    'ufCrm14Bedroom',
    'ufCrm14Bathroom',
    'ufCrm8AgentId',
    'ufCrm8AgentName',
    'ufCrm8AgentEmail',
    'ufCrm8AgentPhone',
    'ufCrm8AgentPhoto',
    'ufCrm14BuildYear',
    'ufCrm14Parking',
    'ufCrm14Furnished',
    'ufCrm_14_360_VIEW_URL',
    'ufCrm14PhotoLinks',
    'ufCrm14FloorPlan',
    'ufCrm14Geopoints',
    'ufCrm14Latitude',
    'ufCrm14Longitude',
    'ufCrm14AvailableFrom',
    'ufCrm14VideoTourUrl',
    'ufCrm14Developers',
    'ufCrm14ProjectName',
    'ufCrm14ProjectStatus',
    'ufCrm14ListingOwner',
    'ufCrm14Status',
    'ufCrm14PfEnable',
    'ufCrm14BayutEnable',
    'ufCrm14DubizzleEnable',
    'ufCrm14SaleType',
    'ufCrm14WebsiteEnable',
    'updatedTime',
    'ufCrm14Amenities'
];

$properties = fetchAllProperties($baseUrl, $entityTypeId, $fields, 'dubizzle');

if (count($properties) > 0) {
    $xml = generateBayutXml($properties);
    echo $xml;
} else {
    echo '<?xml version="1.0" encoding="UTF-8"?><list></list>';
}
