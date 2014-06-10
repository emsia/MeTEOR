 function changeBox()
 {
    document.getElementById('one').style.display='none';
    document.getElementById('two').style.display='';
    document.getElementById('password').focus();
 }
 function restoreBox()
 {
    if(document.getElementById('password').value=='')
    {
      document.getElementById('one').style.display='';
      document.getElementById('two').style.display='none';
    }
 }
 
 function changeBox2()
 {
    document.getElementById('one2').style.display='none';
    document.getElementById('two2').style.display='';
    document.getElementById('email').focus();
 }
 function restoreBox2()
 {
    if(document.getElementById('email').value=='')
    {
      document.getElementById('one2').style.display='';
      document.getElementById('two2').style.display='none';
    }
 }
 
function addInput()
{
	var div1 = document.createElement('div');
	div1.innerHTML = document.getElemetById('addCourse');
	document.getElementById('addCourse').appendChild(div1);
}

$(document).ready(function(){
	/* Adding a colortip to any tag with a title attribute: */
		$('[title]').colorTip({color:'yellow'});
});
var countries = new Array( 'Afghanistan', 'Akrotiri', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Anguilla', 'Antarctica', 
              'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Ashmore and Cartier Islands', 'Australia', 'Austria', 'Azerbaijan', 
              'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Bassas de India', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 
              'Bolivia', 'Bosnia and Herzegovina', 'Botswanna', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory', 'British Virgin Islands', 
              'Brunei', 'Bulgaria', 'Burkina Faso', 'Burma', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 
              'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Clipperton Island', 'Cocoas (Keeling) Islands', 'Colombia', 
              'Comoros', 'Congo (Democratic Republic)', 'Congo (Republic)', 'Cook Islands', 'Coral Sea Islands', 'Costa Rica', "Cote d'lvoire", 
              'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Dhekelia', 'Djibouti', 'Dominica', 'Dominican Republic', 'Ecuador', 
              'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Europa Island', 'Falkland Islands (Islas Malvinas)', 
              'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Guinea', 'French Polynesia', 'French Southern and Antarctic Lands', 'Gabon', 
              'Gambia', 'Gaza Strip', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Glorioso Islands', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 
              'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard Island and McDonald Islands', 
              'Holy See (Vatican City)', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Isle of Man', 
              'Israel', 'Italy', 'Jamaica', 'Jan Mayen', 'Japan', 'Jersey', 'Jordan', 'Juan de Nova Island', 'Kazakhstan', 'Kenya', 'Kiribati', 
              'Korea (North)', 'Korea (South)', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 
              'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 
              'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia (Federated States)', 'Moldova', 'Monaco', 'Mongolia', 
              'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nauru', 'Navassa Island', 'Nepal', 'Netherlands', 'Netherlands Antilles', 
              'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway', 
              'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paracel Islands', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 
              'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'Saint Helena', 'Saint Kitts and Nevis', 
              'Saint Lucia', 'Saint Pierre and Miquelon', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe', 
              'Saudi Arabia', 'Senegal', 'Serbia and Montenegro', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 
              'Somalia', 'South Africa', 'South Georgia and the South Sandwich Islands', 'Spain', 'Spratly Islands', 'Sri Lanka', 'Sudan', 'Suriname', 
              'Svalbard', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo', 
              'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tromelin Island', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 
              'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 
              'Venezuela', 'Vietnam', 'Virgin Islands', 'Wake Island', 'Wallis and Futuna', 'West Bank', 'Western Sahara', 'Yemen', 'Zambia', 
              'Zimbabwe' );
var months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
var days = new Array('', 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

function pop_days( year_id, month_id, day_id, date ){
  
  var selectedMonthIndex = document.getElementById( month_id ).selectedIndex;
  var yearValue = document.getElementById( year_id ).value;
  var daysElement = document.getElementById( day_id );

  daysElement.length=0;  // Fixed by Julian Woods
  daysElement.options[0] = new Option('-- Days --','-1');
  daysElement.selectedIndex = 0;
  
  var state_arr = days[selectedMonthIndex];
  var date_index = 0;
  if( yearValue%4 == 0 && selectedMonthIndex == 2) state_arr++;
  for (var i=0; i<state_arr; i++) {
    daysElement.options[daysElement.length] = new Option(i+1,i+1);
    if(i+1==date) daysElement.selectedIndex = i+1;
  }
}

function pop_months( year_id, month_id, day_id, month ){
  // given the id of the <select> tag as function argument, it inserts <option> tags
  var monthElement = document.getElementById(month_id);
  monthElement.length=0;
  monthElement.options[0] = new Option('-- Month --','-1');
  monthElement.selectedIndex = 0;
  for (var i=0; i<months.length; i++) {
    monthElement.options[monthElement.length] = new Option(months[i],months[i]);
    if(months[i] == month) monthElement.selectedIndex = i+1;
  }
  // Assigned all countries. Now assign event listener for the states.
  if( day_id ){
    pop_days( year_id, month_id, day_id, date );
    monthElement.onchange = function(){
      pop_days( year_id, month_id, day_id, date );
    };
  }
}

function pop_years(year_id, month_id, day_id, year_s, month, date){
  var yearElement = document.getElementById(year_id);
  yearElement.length=0;
  var currentTime = new Date();
  var year = currentTime.getFullYear()
  yearElement.options[0] = new Option('-- Year --','-1');
  yearElement.selectedIndex = 0;
  for (var i=year, count = 0; i >= 1900; i--,count++) {
    yearElement.options[yearElement.length] = new Option(i,i);
    if(i == year_s) yearElement.selectedIndex = count+1;
  }
  
  // Assigned all countries. Now assign event listener for the states.
  if( day_id ){
    pop_months( year_id, month_id, day_id, month, date );
    yearElement.onchange = function(){
      pop_months( year_id, month_id, day_id, month, date );
    };
  }
}

function pop_year(country_id, country){
  var countryElement = document.getElementById(country_id);
  countryElement.length=0;
  countryElement.options[0] = new Option('-- Country --','-1');
  countryElement.selectedIndex = 0;
   for (var i=0; i<countries.length; i++) {
    countryElement.options[countryElement.length] = new Option(countries[i],countries[i]);
    if( countries[i]==country ) countryElement.selectedIndex = i+1;
  }
}

var positions = new Array();
positions[0] = "";
positions[1] = "Accountant|Accountant Systems|Acquisition Management Intern|Actuarial Analyst|Actuary|Administrative Generalist/Specialist|Affordable Housing Specialist|Analyst|Appraiser|Archaeologist|Area Systems Coordinator|Asylum or Immigration Officer|Attorney/Law Clerk|Audience Analyst|Audit Resolution Follow Up|Auditor|Behavioral Scientist|Biologist, Fishery|Biologist, Marine|Biologist, Wildlife|Budget Analyst|Budget Specialist|Business Administration|Officer|Chemical Engineer|Chemist|Citizen Services Specialist|Civil Engineer|Civil Penalties Specialist|Civil/Mechanical/Structural|Engineer|Communications Specialist|Community and Intergovernmental|Program Specialist|Community Planner|Community Planning\Development|Specialist|Community Services Program|Specialist|Compliance Specialist|Computer Engineer|Computer Programmer/Analyst|Computer Scientist|Computer Specialist|Consumer Safety Officer|Contract Specialist|Contract Specialist/Grants|Management Specialist|Corporate Management Analyst|Cost Account|Criminal Enforcement Analyst|Criminal Investigator|Customer Account Manager|Customer Acct Mgr\Specialist|Democracy Specialist|Desk Officer|Disaster Operations Specialist|Disbursing Specialist|Ecologist|Economist|Economist, Financial|Education Specialist|Electrical Engineer|Electronics Engineer|Emergency Management Specialist|Employee and Management Development Specialist|Employee Development Specialist|Employee Relations Specialist|Energy and Environmental Policy Analyst|Energy Program Specialist|Engineer (General)|Environmental Engineer|Environmental Planning and Policy Specialist|Environmental Protection Specialist|Environmental Specialist|Epidemiologist|Equal Employment Opportunity Specialist|Equal Opportunity Specialist|Ethics Program Specialist|Evaluation and Technical Services Generalist|Evaluator|Executive Analyst|Facilities Analyst|Facility Specialist|Federal Retirement Benefits Specialist|Field Management Assistant|Field Office Supervisor|Financial Management Specialist|Financial Legislative Specialist|Financial Specialist|Financial Systems Analyst|Financial Transactions Examination Officer|Food Safety Coordinator|Food Technologist|Foreign Affairs Officer|Foreign Affairs Specialist|Foreign Assets Control Intelligence Analyst|Foreign Assets Control Terrorist Program Analyst|Functional Area Analyst|General Engineer|Geographer|Geographical Information Systems/Computer Aided|Geophysicist|Grants Program Specialist|Grants Specialist|Hazard Mitigation Specialist|Hazardous Waste Generator Initiative Specialist|Health Communications Specialist|Health Educator|Health Insurance Specialist|Health Scientist|Health Systems Specialist|Hospital Finance Associate|Housing Program Specialist|Housing Project Manager|Human Resources Advisor\Consultant|Human Resources Consultant|Human Resources Development|Human Resources Evaluator|Human Resources Representative|Human Resources Specialist|Hydraulic Engineer Immigration Officer|Import Policy Analyst|Industrial Hygienist|Information Management Specialist|Information Research Specialist|Information Resource Management Specialist|Information Technology Policy Analyst|Information Technology Security Assistant|Information Technology Specialist|Inspector|Instructional Systems Design Specialist|Instructions Methods Specialist|Insurance Marketing Specialist|Insurance Specialist|Intelligence Analyst|Intelligence Operations Specialist|Intelligence Research Specialist|Intelligence Specialist|Internal Program Specialist|Internal Revenue Agent|International Affairs Specialist|International Aviation Operations Specialist|International Cooperation Specialist|International Economist|International Project Manager|International Relations Specialist|International Trade Litigation Electronic Database C|International Trade Specialist|International Transportation Specialist|Investigator|Junior Foreign Affairs Officer|Labor Relations Specialist|Learning Specialist|Legislative Assistant|Legislative Analyst|Legislative Specialist|Lender Approval Analyst|Lender Monitoring Analyst|Licensing Examining Specialist/Offices|Logistics Management Specialist|Managed Care Specialist|Management Analyst|Management and Budget Analyst|Management and Program Analyst|Management Intern|Management Support Analyst|Management Support Specialist|Manpower Analyst|Manpower Development Specialist|Marketing Analyst|Marketing Specialist|Mass Communications Producer|Mathematical Statistician|Media Relations Assistant|Meteorologist|Microbiologist|Mitigation Program Specialist|National Security Training Technology Project Manager|Natural Resources Specialist|Naval Architect|Operations Officer|Operations Planner|Operations Research Analyst|Operations Supervisor|Other|Outdoor Recreation Planner|Paralegal Specialist|Passport/Visa Specialist|Personnel Management Specialist|Personnel Staffing and Classification Specialist|Petroleum Engineer|Physical Science Officer|Physical Scientist, General|Physical Security Specialist|Policy Advisor to the Director|Policy Analyst|Policy and Procedure Analyzt|Policy and Regulatory Analyst|Policy Coordinator|Policy/Program Analyst|Population/Family Planning Specialist|Position Classification Specialist|Presidential Management Fellow|Procurement Analyst|Procurement Specialist|Professional Relations Outreach|Program Administrator|Program Analyst|Program and Policy Analyst|Program Evaluation and Risk Analyst|Program Evolution Team Leader|Program Examiner|Program Manager|Program Operations Specialist|Program Specialist|Program Support Specialist|Program/Public Health Analyst|Project Analyst|Prototype Activities Coordinator|Psychologist (General)|Public Affairs Assistant|Public Affairs Intern|Public Affairs Specialist|Public Health Advisor|Public Health Analyst|Public Health Specialist|Public Liaison/Outreach Specialist|Public Policy Analyst|Quantitative Analyst|Real Estate Appraiser|Realty Specialist|Regional Management Analyst|Regional Technician|Regulatory Analyst|Regulatory Specialist|Research Analyst|Restructuring Analyst|Risk Analyst|Safety and Occupational Health Manager|Safety and Occupational Health|Specialist|Safety Engineer/Industrial Hygienist|Science Program Analyst|Securities Compliance Examiner|Security Specialist|Senior Management Information Specialist|Social Insurance Analyst|Social Insurance Policy Specialist|Social Insurance Specialist|Social Science Analyst|Social Science Research Analyst|Social Scientist|South Asia Desk Officer|Special Assistant|Special Assistant for Foreign Policy Strategy|Special Assistant to the Associate Director|Special Assistant to the Chief Information Office|Special Assistant to the Chief, FBI National Security|Special Assistant to the Director|Special Emphasis Program Manager|Special Projects Analyst|Specialist|Staff Associate|Statistician|Supply Systems Analyst|Survey or Mathematical Statistician|Survey Statistician|Systems Accountant|Systems Analyst|Tax Law Specialist|Team Leader|Technical Writer/Editor|Telecommunications Policy Analyst|Telecommunications Specialist|Traffic Management Specialist|Training and Technical Assistant|Training Specialist|Transportation Analyst|Transportation Industry Analyst|Transportation Program Specialist|Urban Development Specialist|Usability Researcher|Veterans' Employment Specialist|Video Production Specialist|Visa Specialist|Work Incentives Coordinator|Worker's Compensation Specialist|Workforce Development Specialist|Worklife Wellness Specialist|Writer|Writer/Editor";

var regions = new Array('Ilocos Region', 'Cagayan Valley', 'Central Luzon', 'CALABARZON', 'MIMAROPA', 'Bicol Region', "Western Visayas", 'Central Visayas', 'Eastern Visayas','Zamboanga Peninsula', 
                  'Northern Mindanao', 'Davao Region', 'SOCCSKSARGEN', 'CARAGA', 'Cordillera Autonomous Region', 'Autonomous Region for Muslim Mindanao', 'National Capital Region', 'Foreign');
var provinces = new Array();
provinces[0] = "";
provinces[1] = "ILOCOS NORTE|ILOCOS SUR|LA UNION|PANGASINAN"; //ilocos
provinces[2] = "BATANES|CAGAYAN|ISABELA|NUEVA VISCAYA|QUIRINO"; //cagayan
provinces[3] = "AURORA|BATAAN|BULACAN|NUEVA ECIJA|PAMPANGA|TARLAC|ZAMBALES"; //central luzon
provinces[4] = "BATANGAS|CAVITE|LAGUNA|QUEZON|RIZAL"; //calabarzon
provinces[5] = "MARINDUQUE|OCCIDENTAL MINDORO|ORIENTAL MINDORO|PALAWAN|ROMBLON"; //mimaropa
provinces[6] = "ALBAY|CAMARINES NORTE|CAMARINES SUR|CATANDUANES|MASBATE|SORSOGON"; //bicol region
provinces[7] = "AKLAN|ANTIQUE|CAPIS|GUIMARAS|ILOILO|NEGROS OCCIDENTAL"; //west
provinces[8] = "BOHOL|CEBU|NEGROS ORIENTAL|SIQUIJOR"; //central
provinces[9] = "BILIRAN|EASTERN SAMAR|LEYTE|SAMAR|SOUTHERN LEYTE"; //zamboanga
provinces[10] = "ZAMBOANGA DEL NORTE|ZAMBOANGA DEL SUR|ZAMBOANGA SIBUGAY"; 
provinces[11] = "BUKIDNON|CAMIGUIN|LANAO DEL NORTE|MISAMIS OCCIDENTAL|MISAMIS ORIENTAL";
provinces[12] = "COMPOSTELA VALLEY|DAVAO DEL NORTE|DAVAO DEL SUR|DAVAO ORIENTAL";
provinces[13] = "COTABATO|SARANGANI|SOUTH COTABATO|SULTAN KUDARAT|COTABATO CITY";
provinces[14] = "AGUSAN DEL NORTE|AGUSAN DEL SUR|DINAGAT ISLANDS|SURIGAO DEL NORTE|SURIGAO DEL SUR";
provinces[15] = "ABRA|APAYAO|BENGUET|IFUGAO|KALINGA|MOUNTAIN PROVINCE";
provinces[16] = "BASILAN|LANAO DEL SUR|MAGUINDANAO|SHARIFF KABUNSUAN|SULU|TAWI-TAWI";
provinces[17] = "KALOOKAN CITY (NORTH)|KALOOKAN CITY (SOUTH)|LAS PIÑAS CITY|MAKATI CITY|MALABON CITY|MANDALUYONG CITY|MANILA|MARIKINA CITY|MUNTINLUPA CITY|NAVOTAS CITY|PARAÑAQUE CITY|PASAY CITY|PASIG CITY|PATEROS|QUEZON CITY|SAN JUAN CITY|TAGUIG CITY|VALENZUELA CITY";

var cities = new Array();

cities[0] = "";

//prov - 1
cities[1] = "CITY OF BATAC|LAOAG CITY|ADAMS|BACARRA|BADOC|BANGUI|BANNA|BURGOS|CARASI|CURRIMAO|DINGRAS|DUMALNEG|MARCOS|NUEVA ERA|PAGUDPUD|PAOAY|PASUQUIN|PIDDIG|PINILI|SAN NICOLAS|SARRAT|SOLSONA|VINTAR";
cities[2] = "CANDON CITY|VIGAN CITY|ALILEM|BANAYOYO|BANTAY|BURGOS|CABUGAO|CAOAYAN|CERVANTES|GALIMUYOD|G. DEL PILAR|LIDLIDDA|MAGSINGAL|NAGBUKEL|NARVACAN|QUIRINO|SALCEDO|SAN EMILIO|SAN ESTEBAN|SAN ILDEFONSO|SAN JUAN|SANTA|SANTA CATALINA|SANTA CRUZ|SANTA LUCIA|SANTA MARIA|SANTIAGO|SANTO DOMINGO|SAN VICENTE|SIGAY|SINAIT|SUGPON|SUYO|TAGUDIN";
cities[3] = "SAN FERNANDO CITY|AGOO|ARINGAY|BACNOTAN|BAGULIN|BALAOAN|BANGAR|BAUANG|BURGOS|CABA|LUNA|NAGUILIAN|PUGO|ROSARIO|SAN GABRIEL|SAN JUAN|SANTOL|SANTO TOMAS|SUDIPEN|TUBAO";
cities[4] = "ALAMINOS CITY|DAGUPAN CITY|SAN CARLOS CITY|URDANETA CITY|AGNO|AGUILAR|ALCALA|ANDA|ASINGAN|BALUNGAO|BANI|BASISTA|BAUTISTA|BAYAMBANG|BINALONAN|BINMALEY|BOLINAO|BUGALLON|BURGOS|CALASIAO|DASOL|INFANTA|LABRADOR|LAOAC|LINGAYEN|MABINI|MANAOAG|MALASIQUE|MANGALDAN|MANGATAREM|MAPANDAN|NATIVIDAD|POZORRUBIO|ROSALES|SAN FABIAN|SAN JACINTO|SAN MANUEL|SAN NICOLAS|SAN QUINTIN|SANTA BARBARA|SANTA MARIA|SANTO TOMAS|SISON|SUAL|TAYUG|UMINGAN|URBIZTONDO|VILLASIS";

//prov - 2
cities[5] = "BASCO|ITBAYAT|IVANA|MAHATAO|SABTANG|UYUGAN";
cities[6] = "TUGUEGARAO CITY|ABULUG|ALCALA|ALLACAPAN|AMULUNG|APARRI|BAGGAO|BALLESTEROS|BUGUEY|CALAYAN|CAMALANIUGAN|CLAVERIA|ENRILE|GATTARAN|GONZAGA|IGUIG|LAL-LO|LASAM|PAMPLONA|PEÑABLANCA|PIAT|RIZAL|SANCHEZ-MIRA|SANTA ANA|SANTA PRAXEDES|SANTA TERESITA|SANTO NIÑO|SOLANA|TUAO";
cities[7] = "CAUAYAN CITY|SANTIAGO CITY|ALICIA|ANGADANAN|AURORA|BENITO SOLIVEN|BURGOS|CABAGAN|CABATUAN|CORDON|DELFIN ALBANO|DINAPIGUE|DIVILICAN|ECHAGUE|GAMU|ILAGAN|JONES|LUNA|MACONACON|MALLIG|NAGUILAN|PALANAN|QUEZON|QUIRINO|RAMON|REINA MERCEDES|ROXAS|SAN AGUSTIN|SAN GUILLERMO|SAN ISIDRO|SAN MANUEL|SAN MARIANO|SAN MATEO|SAN PABLO|SANTA MARIA|SANTO TOMAS|TUMAUINI";
cities[8] = "ALFONSO CASTAÑEDA|AMBAGUIO|ARITAO|BAGABAG|BAMBANG|BAYOMBONG|DIADI|DUPAX DEL NORTE|DUPAX DEL SUR|KASIBU|KAYAPA|QUEZON|SANTA FE|SOLANO|VILLAVERDE";
cities[9] = "AGLIPAY|CABARROGUIS|DIFFUN|MADDELA|NAGTIPUNAN|SAGUDAY";

//prov - 3
cities[10] = "BALER|CASIGURAN|DILASAG|DINALUNGAN|DINGALAN|DIPACULAO|MA. AURORA|SAN LUIS";
cities[11] = "BALANGA CITY|ABUCAY|BAGAC|DINALUPIHAN|HERMOSA|LIMAY|MARIVELES|MORONG|ORANI|ORION|PILAR|SAMAL";
cities[12] = "MEYCAUAYAN CITY|MALOLOS CITY|SAN JOSE DEL MONTE CITY|ANGAT|BALAGTAS|BALIUAG|BOCAUE|BULACAN|BUSTOS|CALUMPIT|DRT|GUIGUINTO|HAGONOY|MARILAO|NORZAGARAY|OBANDO|PANDI|PAOMBONG|PLARIDEL|PULILAN|SAN ILDEFONSO|SAN MIGUEL|SAN RAFAEL|SANTA MARIA";
cities[13] = "CABANATUAN CITY|GAPAN CITY|MUÑOZ CITY|PALAYAN CITY|SAN JOSE CITY|ALIAGA|BONGABON|CABIAO|CARANGLAN|CUYAPO|GABALDON|GEN MAMERTO NATIVIDAD|GENERAL TINIO|GUIMBA|JAEN|LAUR|LLANERA|LICAB|LUPAO|NAMPICUAN|PANTABANGAN|PEÑARANDA|QUEZON|RIZAL|SAN ANTONIO|SAN ISIDRO|SAN LEONARDO|SANTA ROSA|SANTO DOMINGO|TALAVERA|TALUGTUG|ZARAGOZA";
cities[14] = "ANGELES CITY|CITY OF SAN FERNANDO|APALIT|ARAYAT|BACOLOR|CANDABA|FLORIDABLANCA|GUAGUA|LUBAO|MABALACAT|MACABEBE|MAGALANG|MASANTOL|MEXICO|MINALIN|PORAC|SAN LUIS|SAN SIMON|SASMUAN|SANTA ANA|SANTA RITA|SANTO TOMAS";
cities[15] = "TARLAC CITY|ANAO|BAMBAN|CAMILING|CAPAS|CONCEPCION|GERONA|LA PAZ|MAYANTOC|MONCADA|PANIQUI|PURA|RAMOS|SAN CLEMENTE|SAN JOSE|SAN MANUEL|STA. IGNACIA|VICTORIA";
cities[16] = "OLONGAPO CITY|BOTOLAN|CABANGAN|CANDELARIA|CASTILLEJOS|IBA|MASINLOC|PALAUIG|SAN ANTONIO|SAN FELIPE|SAN MARCELINO|SAN NARCISO|SANTA CRUZ|SUBIC";

//prov - 4
cities[17] = "BATANGAS CITY|LIPA CITY|TANAUAN CITY|AGONCILLO|ALITAGTAG|BALAYAN|BALETE|BAUAN|CALACA|CALATAGAN|CUENCA|IBAAN|LAUREL|LEMERY|LIAN|LOBO|MABINI|MALVAR|MATAASNAKAHOY|NASUGBU|PADRE GARCIA|ROSARIO|SAN JOSE|SAN JUAN|SAN LUIS|SAN NICOLAS|SAN PASCUAL|SANTA TERESITA|SANTO TOMAS|TAAL|TALISAY|TAYSAN|TINGLOY|TUY";
cities[18] = "CAVITE CITY|TAGAYGAY CITY|TRECE MARTIRES|ALFONSO|AMADEO|BACOOR|CARMONA|DASMARIÑAS|GEN. AGUINALDO|GEN. M. ALVAREZ|GEN. TRIAS|IMUS|INDANG|KAWIT|MAGALLANES|MARAGONDON|MENDEZ|NAIC|NOVELETA|ROSARIO|SILANG|TANZA|TERNATE";
cities[19] = "CALAMBA CITY|SANTA ROSA CITY|SAN PABLO CITY|ALAMINOS|BAY|BIÑAN|CABUYAO|CALAUAN|CAVINTI|FAMY|KALAYAAN|LILIW|LOS BAÑOS|LUISIANA|LUMBAN|MABITAC|MAGDALENA|MAJAYJAY|NAGCARLAN|PAETE|PAGSANJAN|PAKIL|PANGIL|PILA|RIZAL|SAN PEDRO|SANTA CRUZ|SANTA MARIA|SINILOAN|VICTORIA";
cities[20] = "LUCENA CITY|CITY OF TAYABAS|AGDANGAN|ALABAT|ATIMONAN|BUENAVISTA|BURDEOS|CALAUAG|CANDELARIA|CATANAUAN|DOLORES|GENERAL LUNA|GENERAL NAKAR|GUINAYANGAN|GUMACA|INFANTA|JOMALIG|LOPEZ|LUCBAN|MACALELON|MAUBAN|MULANAY|PADRE BURGOS|PAGBILAO|PANUKULAN|PATNANUNGAN|PEREZ|PITOGO|PLARIDEL|POLILLO|QUEZON|REAL|SAMPALOC|SAN ANDRES|SAN ANTONIO|SAN FRANCISCO|SAN NARCISO|SARIAYA|TAGKAWAYAN|TIAONG|UNISAN";
cities[21] = "ANTIPOLO CITY|ANGONO|BARAS|BINANGONAN|CAINTA|CARDONA|JALAJALA|MORONG|PILILLA|RODRIGUEZ (MONTALBAN)|SAN MATEO|TANAY|TAYTAY|TERESA DELA";

//prov - 5
cities[22] = "BOAC|BUENAVISTA|GASAN|MOGPOG|SANTA CRUZ|TORRIJOS";
cities[23] = "ABRA DE ILOG|CALINTAAN|LOOC|LUBANG|MAGSAYSAY|MAMBURAO|PALUAN|RIZAL|SABLAYAN|SAN JOSE|SANTA CRUZ";
cities[24] = "CALAPAN CITY|BACO DELA|BANSUD|BONGABONG|BULALACAO|GLORIA|MANSALAY|NAUJAN|PINAMALAYAN|POLA|PUERTO GALERA|ROXAS|SAN TEODORO|SOCORRO|VICTORIA";
cities[25] = "PUERTO PRINCESA CITY|ABORLAN|AGUTAYA|ARACELI|BALABAC|BATARAZA|BROOKE'S POINT|BUSUANGA DE|CAGAYANCILLO|CORON|CULION|CUYO|DUMARAN|EL NIDO|KALAYAAN|LINAPACAN|MAGSAYSAY|NARRA|QUEZON|RIZAL|ROXAS|SAN VICENTE|SOFRONIO|TAYTAY";
cities[26] = "ALCANTARA|BANTON|CAJIDIOCAN|CALATRAVA|CONCEPCION|CORCUERA|FERROL|LOOC|MAGDIWANG|ODIONGAN|ROMBLON|SAN AGUSTIN|SAN ANDRES|SAN FERNANDO|SAN JOSE|SANTA FE|SANTA MARIA";

//prov - 6
cities[27] = "LEGAZPI CITY|LIGAO CITY|TABACO CITY|BACACAY|CAMALIG|DARAGA|GUINOBATAN|JOVELLAR|LIBON|MALILIPOT|MALINAO|MANITO|OAS|PIO DURAN|POLANGUI|RAPU-RAPU|SANTO DOMINGO|TIWI";
cities[28] = "BASUD|CAPALONGA|DAET|JOSE PANGANIBAN|LABO|MERCEDES|PARACALE|SAN LORENZO RUIZ|SAN VICENTE|SANTA ELENA|TALISAY|VINZONS";
cities[29] = "IRIGA CITY|NAGA CITY|BAAO|BALATAN|BATO|BOMBON ANGELES|BUHI|BULA|CABUSAO|CALABANGA|CAMALIGAN|CANAMAN|CARAMOAN|DEL GALLEGO|GAINZA|GARCHITORENA|GOA|LAGONOY|LIBMANAN|LUPI|MAGARAO|MILAOR|MINALABAC|NABUA|OCAMPO|PAMPLONA|PASACAO ARCEÑO|PILI|PRESENTACION|RAGAY|SAGNAY|SAN FERNANDO|SAN JOSE|SIPOCOT|SIRUMA|TIGAON|TINAMBAC";
cities[30] = "BAGAMANOC|BARAS|BATO|CARAMORAN|GIGMOTO|PANDAN|PANGANIBAN|SAN ANDRES|SAN MIGUEL|VIGA|VIRAC";
cities[31] = "MASBATE CITY|AROROY|BALENO|BALUD|BATUAN|CATAINGAN|CAWAYAN|CLAVERIA|DIMASALANG|ESPERANZA|MANDAON|MILAGROS|MOBO|MONREAL|PALANAS ALVAREZ|PIO V. CORPUZ|PLACER|SAN FERNANDO|SAN JACINTO|SAN PASCUAL|USON";
cities[32] = "SORSOGON CITY|BARCELONA|BULAN DE|BULUSAN|CASIGURAN|CASTILLA|DONSOL|GUBAT|IROSIN|JUBAN|MAGALLANES|MATNOG SO|PILAR|PRIETO DIAZ|SANTA MAGDALENA";

//prov - 7
cities[33] = "ALTAVAS|BALETE|BANGA|BATAN|BURUANGA|IBAJAY|KALIBO|LEZO|LIBACAO|MADALAG|MAKATO|MALAY|MALINAO|NABAS|NEW WASHINGTON|NUMANCIA|TANGALAN";
cities[34] = "ANINI-Y|BARBAZA FRANCISCO|BELISON|BUGASONG|CALUYA|CULASI|HAMTIC|LAUA-AN|LIBERTAD|PANDAN|PATNONGON|SAN JOSE|SAN REMEGIO|SEBASTE|SIBALOM|TIBIAO|TOBIAS FORNIER|VALDERRAMA";
cities[35] = "ROXAS CITY|CUARTERO|DAO|DUMALAG|DUMARAO|IVISAN|JAMINDAN|MAAYON|MAMBUSAO|PANAY|PANITAN|PILAR|PONTEVEDRA|PRES. ROXAS|SAPI-AN|SIGMA|TAPAZ";
cities[36] = "BUENAVISTA|JORDAN|NUEVA VALENCIA|SAN LORENZO|SIBUNAG";
cities[37] = "ILOILO CITY|PASSI CITY|AJUY|ALIMODIAN|ANILAO|BADIANGAN|BALASAN|BANATE|BAROTAC NUEVO|BAROTAC VIEJO|BATAD|BINGAWAN|CABATUAN|CALINOG|CARLES|CONCEPCION|DINGLE|DUEÑAS|DUMANGAS|ESTANCIA|GUIMBAL|IGBARAS|JANIUAY|LAMBUNAO|LEGANES|LEMERY|LEON|MAASIN|MIAGAO|MINA|NEW LUCENA|OTON|PAVIA|POTOTAN|SAN DIONISIO|SAN ENRIQUE|SAN JOAQUIN|SAN MIGUEL|SAN RAFAEL|SARA|SANTA BARBARA|TIGBAUAN|TUBUNGAN|ZARRAGA";
cities[38] = "BACOLOD CITY|BAGO CITY|CADIZ CITY|ESCALANTE CITY|HIMAMAYLAN CITY|KABANKALAN CITY|LA CARLOTA CITY|SAGAY CITY|SAN CARLOS CITY|SILAY CITY|SIPALAY CITY|TALISAY CITY|VICTORIAS CITY|BINALBAGAN|CALATRAVA|CANDONI|CAUAYAN|DS BENEDICTO|EB MAGALONA|HINIGARAN|HINOBA-AN|ILOG|ISABELA|LA CASTELLANA|MANAPLA|MOISES PADILLA|MURCIA|PONTEVEDRA|PULUPANDAN|SAN ENRIQUE|TABOSO|VALLADOLID";

//prov - 8
cities[39] = "TAGBILARAN CITY|ALBURQUERQUE|ALICIA|ANDA|ANTEQUERA|BACLAYON|BALILIHAN|BATUAN|BIEN UNIDO|BILAR|BUENAVISTA|CALAPE|CANDIJAY|CARMEN|CATIGBIAN|CLARIN|CORELLA|CORTES|DAGOHOY|DANAO|DAUIS|DIMIAO|DUERO|GARCIA HERNANDEZ|GETAFE|GUINDULMAN|INABANGA|JAGNA|LILA|LOAY|LOBOC|LOON|MABINI|MARIBOJOC|PANGLAO|PILAR|PRES CP GARCIA|SAGBAYAN|SAN ISIDRO|SAN MIGUEL|SEVILLA|SIERRA BULLONES|SIKATUNA|TALIBON|TRINIDAD|TUBIGON|UBAY|VALENCIA";
cities[40] = "CEBU CITY|CITY OF BOGO|CITY OF CARCAR|LAPU LAPU CITY|MANDAUE CITY|TALISAY CITY|DANAO CITY|TOLEDO CITY|ALCANTARA|ALCOY DELOS|ALEGRIA|ALOGUINSAN|ARGAO|ASTURIAS|BADIAN|BALAMBAN|BANTAYAN|BARILI|BOLJOON|BORBON|CARMEN|CATMON|COMPOSTELA|CONSOLACION|CORDOVA|DAANBANTAYAN|DALAGUETE|DUMANJUG|GINATILAN|LILOAN|MADRIDEJOS|MALABUYOC|MEDELLIN|MINGLANILLA|MOALBOAL|CITY OF NAGA|OSLOB|PILAR|PINAMUNGAHAN|PORO|RONDA|SAMBOAN|SAN FERNANDO|SAN FRANCISCO|SAN REMEGIO|SANTANDER|SANTA FE|SIBONGA|SOGOD|TABOGON|TABUELAN|TUBURAN|TUDELA";
cities[41] = "BAIS CITY|BAYAWAN CITY|CANLAON CITY|DUMAGUETE CITY|TANJAY CITY|AMLAN DELA|AYUNGON|BACONG|BASAY|BINDOY|DAUIN|GUIHULNGAN|JIMALALUD|LA LIBERTAD|MABINAY|MANJUYOD|PAMPLONA|SAN JOSE|SANTA CATALINA|SIATON|SIBULAN|TAYASAN|VALENCIA|VALLEHERMOSO|ZAMBOANGUITA";
cities[42] = "ENRIQUE VILLANUEVA|LARENA|LAZI|MARIA|SAN JUAN|SIQUIJOR";

//prov - 9
cities[43] = "ALMERIA|BILIRAN|CABUCGAYAN|CAIBIRAN|CULABA|KAWAYAN|MARIPIPI|NAVAL";
cities[44] = "CITY OF BORONGAN|ARTECHE|BALANGIGA DE|BALANGKAYAN|CAN-AVID|DOLORES|GEN. MACARTHUR|GIPORLOS|GUIUAN|HERNANI|JIPAPAD|LAWAAN|LLORENTE|MASLOG|MAYDOLONG|MERCEDES|ORAS|QUINAPONDAN|SALCEDO|SAN JULIAN|SAN POLICARPIO|SULAT|TAFT";
cities[45] = "ORMOC CITY|TACLOBAN CITY|ABUYOG|ALANGALANG|ALBUERA DE LA|BABATNGON|BARUGO|BATO|BAYBAY|BURAUEN|CALUBIAN|CAPOOCAN|CARIGARA|DAGAMI|DULAG|HILONGOS|HINDANG|INOPACAN|ISABEL|JARO|JAVIER|JULITA|KANANGA|LA PAZ|LEYTE|MAC ARTHUR|MAHAPLAG|MATAG-OB|MATALOM|MAYORGA|MERIDA|PALO|PALOMPON|PASTRANA|SAN ISIDRO|SAN MIGUEL|SANTA FE|TABANGO|TANAUAN|TOLOSA|TABONTABON|TUNGA|VILLABA";
cities[46] = "CALBAYOG CITY|ALMAGRO|BASEY|CALBIGA|CATBALOGAN|DARAM|GANDARA|HINABANGAN|JIABONG|MARABUT|MATUGUINAO|MOTIONG|PAGSANGHAN|PARANAS|PINABACDAO|SAN JORGE|SAN JOSE DE BUAN|SAN SEBASTIAN|STA. MARGARITA|STA. RITA|STO. NIÑO|TAGAPUL-AN|TALALORA|TARANGNAN|VILLAREAL|ZUMARRAGA";
cities[47] = "MAASIN CITY|ANAHAWAN|BONTOC|HINUNANGAN|HINUNDAYAN|LIBAGON|LILOAN|LIMASAWA|MACROHON|MALITBOG|PADRE BURGOS|PINTUYAN|SAINT BERNARD|SAN FRANCISCO|SAN JUAN|SAN RICARDO|SILAGO|SOGOD|TOMAS OPPUS";

//prov - 10
cities[48] = "DAPITAN CITY|DIPOLOG CITY|ISABELA CITY|BALIGUIAN|GODOD|GUTALAC|JOSE DALMAN|KALAWIT|KATIPUNAN|LABASON|LA LIBERTAD|LEON POSTIGO (BACUNGAN)|LILOY|MANUKAN|MUTIA|PIÑAN|POLANCO|RIZAL|ROXAS|SALUG|SERGIO OSMEÑA|SIAYAN|SIBUCO|SIBUTAD|SINDANGAN|SIOCON|SIRAWAI|TAMPILISAN";
cities[49] = "PAGADIAN CITY|ZAMBOANGA CITY|AURORA|BAYOG|DIMATALING|DINAS|DUMALINAO|DUMINGAG|GUIPOS|JOSEFINA|KUMALARANG|LABANGAN|LAKEWOOD|LAPUYAN|MAHAYAG|MARGOSATUBIG|MIDSALIP|MOLAVE|PITOGO|RAMON MAGSAYSAY|SAN MIGUEL|SAN PABLO|SOMINOT|TABINA|TAMBULIG|TIGBAO|TUKURAN|V. SAGUN";
cities[50] = "ALICIA|BUUG|DIPLAHAN|IMELDA|IPIL|KABASALAN|MABUHAY|MALANGAS|NAGA|OLUTANGA|PAYAO|RT LIM|SIAY|TALUSAN|TITAY|TUNGAWAN";

//prov - 11
cities[51] = "MALAYBALAY CITY|VALENCIA CITY|BAUNGON|CABANGLASAN|DAMULOG|DANGCAGAN|DON CARLOS|IMPASUG-ONG|KADINGILAN|KALILANGAN|KIBAWE|KITAOTAO|LANTAPAN|LIBONA|MALITBOG DELA|MANOLO FORTICH|MARAMAG|PANGANTUCAN|QUEZON|SAN FERNANDO|SUMILAO|TALAKAG";
cities[52] = "CATARMAN|GUINSILIBAN|MAHINOG|MAMBAJAO|SAGAY";
cities[53] = "ILIGAN CITY|BACOLOD|BALOI|BAROY|KAPATAGAN|KAUSWAGAN|KOLAMBUGAN|LALA|LINAMON|MAGSAYSAY|MAIGO|MATUNGAO|MUNAI|NUNUNGAN|PANTAO RAGAT|PANTAR|POONA PIAGAPO|SALVADOR|SAPAD|SULTAN NAGA DIMAPORO|TAGOLOAN|TANGKAL|TUBOD";
cities[54] = "OROQUIETA CITY|OZAMIS CITY|TANGUB CITY|ALORAN|BALIANGAO|BONIFACIO|CALAMBA|CLARIN|CONCEPCION|DON VICTORIANO|JIMENEZ|LOPEZ JAENA|PANAON|PLARIDEL|SAPANG DALAGA|SINACABAN|TUDELA";
cities[55] = "CAGAYAN DE ORO CITY|GINGOOG CITY|CITY OF EL SALVADOR|ALUBIJID|BALINGASAG|BALINGOAN|BINUANGAN|CLAVERIA|GITAGUM|INITAO|JASAAN|KINOGUITAN|LAGONGLONG|LAGUINDINGAN|LIBERTAD|LUGAIT|MAGSAYSAY|MANTICAO|MEDINA|NAAWAN|OPOL|SALAY|SUGBONGCOGON|TAGOLOAN|TALISAYAN|VILLANUEVA";

//prov - 12
cities[56] = "COMPOSTELA|LAAK|MABINI|MACO|MARAGUSAN|MAWAB|MONKAYO|MONTEVISTA|NABUNTURAN|NEW BATAAN|PANTUKAN";
cities[57] = "ISLAND GARDEN CITY OF SAMAL|PANABO CITY|TAGUM CITY|ASUNCION|BRAULIO E DUJALI|CARMEN|KAPALONG|NEW CORELLA|SAN ISIDRO|SANTO TOMAS|TALAINGOD";
cities[58] = "DAVAO CITY|DIGOS CITY|BANSALAN|DON MARCELINO|HAGONOY|JOSE ABAD SANTOS|KIBLAWAN|MAGSAYSAY|MALALAG|MALITA|MATANAO|PADADA|SANTA CRUZ|SANTA MARIA|SARANGANI|SULOP";
cities[59] = "CITY OF MATI |BAGANGA|BANAYBANAY|BOSTON|CARAGA|CATEEL|GOVERNOR GENEROSO|LUPON|MANAY|SAN ISIDRO|TARRAGONA";

//prov - 13
cities[60] = "CITY OF KIDAPAWAN|ALAMADA|ALEOSAN|ANTIPAS|ARAKAN|BANISILAN|CARMEN|KABACAN|LIBUNGAN|MAGPET|MAKILALA|MATALAM|MIDSAYAP|M'LANG|PIGKAWAYAN|PIKIT|PRESIDENT ROXAS|TULUNAN";
cities[61] = "ALABEL|GLAN|KIAMBA|MAASIM|MAITUM|MALAPATAN|MALUNGON";
cities[62] = "GENERAL SANTOS CITY|KORONADAL CITY|BANGA|LAKE SEBU|NORALA|POLOMOLOK|SANTO NIÑO|SURALLAH|TAMPAKAN|TANTANGAN|T'BOLI|TUPI";
cities[63] = "TACURONG CITY|BAGUMBAYAN|COLUMBIO|ESPERANZA|ISULAN|KALAMANSIG|LAMBAYONG (M. MARCOS)|LEBAK|LUTAYAN|PALIMBANG|PRESIDENT QUIRINO|SEN. NINOY AQUINO";
cities[64] = "COTABATO CITY";

//prov - 14
cities[65] = "BUTUAN CITY |CITY OF CABADBARAN|BUENAVISTA|CARMEN|JABONGA|KITCHARO|LAS NIEVES|MAGALLANES|NASIPIT|RT ROMUALDEZ|SANTIAGO|TUBAY";
cities[66] = "CITY OF BAYUGAN|BUNAWAN|ESPERANZA|LA PAZ|LORETO|PROSPERIDAD|ROSARIO|SAN FRANCISCO|SAN LUIS|SIBAGAT|SANTA JOSEFA|TALACOGON|TRENTO|VERUELA";
cities[67] = "BASILISA|CAGDIANAO|DINAGAT|LIBJO|LORETO|SAN JOSE|TUBAJON";
cities[68] = "SURIGAO CITY|ALEGRIA|BACUAG|BURGOS|CLAVER|DAPA|DEL CARMEN|GENERAL LUNA|GIGAQUIT|MAINIT|MALIMONO|PILAR|PLACER|SAN BENITO|SAN FRANCISCO|SAN ISIDRO|SISON|SOCORRO|SANTA MONICA|TAGANA-AN|TUBOD";
cities[69] = "BISLIG CITY|CITY OF TANDAG|BAROBO|BAYABAS|CAGWAIT|CANTILAN|CARMEN|CARRASCAL|CORTES|HINATUAN|LANUZA|LIANGA|LINGIG|MADRID|MARIHATAG|SAN AGUSTIN|SAN MIGUEL|TAGO|TAGBINA";

//prov - 15
cities[70] = "BANGUED|BOLINEY|BUCAY|BUCLOC|DAGUIOMAN|DANGLAS|DOLORES|LA PAZ|LACUB|LAGANGILANG|LAGAYAN|LANGIDEN|LICUAN-BAAY|LUBA|MALIBCONG|MANABO|PEÑARRUBIA|PIDIGAN|PILAR|SALLAPADAN|SAN ISIDRO|SAN JUAN|SAN QUINTIN|TAYUM|TINEG|TUBO|VILLAVICIOSA";
cities[71] = "CALANASAN|CONNER|FLORA|KABUGAO|LUNA|PUDTOL|SANTA MARCELA";
cities[72] = "BAGUIO CITY|ATOK|BAKUN|BOKOD|BUGUIAS|ITOGON|KABAYAN|KAPANGAN|KIBUNGAN|LA TRINIDAD|MANKAYAN|SABLAN|TUBA|TUBLAY";
cities[73] = "AGUINALDO|ALFONSO LISTA|ASIPULO|BANAUE|HINGYON|HUNGDUAN CUYAHON|KIANGAN|LAGAWE|LAMUT|MAYOYAO|TINOC";
cities[74] = "BALBALAN|LUBUAGAN|PASIL|PINUKPUK|RIZAL DELA|CITY OF TABUK|TANUDAN|TINGLAYAN";
cities[75] = "BARLIG|BAUKO|BESAO|BONTOC|NATONIN|PARACELIS|SABANGAN|SADANGA|SAGADA|TADIAN";

//prov - 16
cities[76] = "ISABELA CITY|LAMITAN|LANTAWAN|MALUSO|SUMISIP|TIPO-TIPO|TUBURAN|AKBAR|AL-BARKA|HADJI MOHAMMAD AJUL|UNGKAYA PUKAN|HADJI MUHTAMAD MO#269";
cities[77] = "MARAWI CITY|BACOLOD-KALAWI|BALABAGAN|BALINDONG|BAYANG|BINIDAYAN|BUADIPOSO-BUNTONG|BUBONG|BUMBARAN|BUTIG|CALANOGAS|DITSAAN-RAMAIN|GANASSI|KAPAI|KAPATAGAN|LUMBA-BAYABAO|LUMBACA-UNAYAN|LUMBATAN|LUMBAYANAGUE|MADALUM|MADAMBA|MAGUING|MALABANG|MARANTAO|MAROGONG|MASIU|MULONDO|PAGAYAWAN|PIAGAPO|PICONG|POONA BAYABAO|PUALAS|SAGUIARAN|SULTAN DUMALONDONG|SULTAN GUMANDER|TAGOLOAN|TAMPARAN|TARAKA|TUBARAN|TUGAYA|WAO";
cities[78] = "COTABATO CITY|AMPATUAN|BARIRA|BULDON|BULUAN|DATU ABDULLAH SANGKI|DATU ANGGAL MIDTIMBANG|DATU MONTAWAL|DATU ODIN SINSUAT|DATU PAGLAS|DATU PIANG|DATU SAUDI AMPATUAN|DATU UNSAY|GEN. SALIPADA K. PENDATUN|GUINDULUNGAN|MAGANOY|MAMASAPANO|MANGUDADATU|MATANOG|PAGALUNGAN|PAGLAT|PANDAG|PARANG|SULTAN KUDARAT|KABUNTALAN|UPI|RAJAH BUAYAN|SHARIFF AGUAK|SOUTH UPI|SULTAN SA BARONGIS|TALAYAN|TALITAY|";
cities[79] = "BARIRA|BULDON|DATU BLAH SINSUAT|DATU ODIN SINSUAT|KABUNTALAN|MATANOG|PARANG|SULTAN KUDARAT|SULTAN MASTURA|UPI|NORTHERN KABUNTALAN";
cities[80] = "HADJI PANGLIMA TAHIL|INDANAN|JOLO|KALINGALAN CALAUANG|LUGUS|LUUK|MAIMBUNG|OLD PANAMAO|PANDAMI|PANGLIMA ESTINO|PANGUTARAN|PARANG|PATA|PATIKUL|SIASI|TALIPAO|TAPUL|TONGKIL";
cities[81] = "BONGAO|LANGUYAN|MAPUN|PANGLIMA SUGALA|SAPA-SAPA|SIBUTU|SIMUNUL|SITANGKAI|SOUTH UBIAN|TANDUBAS|TURTLE ISLANDS";
//cities[76] = "";

//prov - 17
cities[82] = "Amparo Subdivision|Bagong Silang|Bagumbong/Pag-asa|Bankers Village|Capitol Parkland Subd.|Kaybiga/Deparo|Lilles Ville Subd.|Novaliches North|Tala Leprosarium|Victory Heights";
cities[83] = "1st to 7th Ave. West|Baesa|Fish Market|Grace Park East|Grace Park West|Isla de Cocomo|Kaloocan City CPO|Kapitbahayan East|Kanluran Village|Maypajo|San Jose|Sangandaan|Sta. Quiteria|University Hills";
cities[84] = "Almanza|Angela Village|Cut-cut|Gatchalian Subd.|Las Pinas CPO|Manila Doctor's Village|Manuyo|Remarville Subd.|Soldiers Hills Subd.|Talon Moonwalk|T. S. Cruz Subd.|Verdant Acres Subd.|Pulang Lupa & Zapote|Pulang Lupa";
cities[85] = "Ayala-Paseo de Roxas|Bangkal|Bel-air|Cembo|Comembo|Dasmarinas Village North|Dasmarinas Village South|Forbes Park North|Forbes Park South|Fort Bonifacio Naval Stn.|Fort Bonifacio (Camp)|Guadalupe Nuevo|Guadalupe Viejo|Kasilawan|La Paz-Singkamas-Tejeros|Legaspi Village|Magallanes Village|Olympia|Carmona|Palanan|Pasong Tamo|Ecology Vill|Pembo|Pinagkaisahan-Pitogo|Pio del Pilar|Poblacion|Rembo (East)|Rembo (West)|Salcedo Village|San Antonio Village|San Isidro|San Lorenzo Village|Sta. Cruz|Urdaneta Village|Valenzuela, Santiago, Rizal";
cities[86] = "Acacia|Araneta Subdivision|Dampalit|Flores|Kaunlaran Village|Longos|Malabon|Maysilo|Muzon|Potrero|Santolan|Tonsuya";
cities[87] = "East Edsa|Greenhills South|Mandaluyong CPO|Vergara";
cities[88] = "Binondo|Intramuros|Malate|Ermita|Paco|Pandacan|Port Area (South)|Quiapo|Sampaloc East|Sampaloc West|San Andres Bukid|San Miguel|San Nicolas|Sta. Ana|Sta. Cruz North|Sta. Cruz South|Sta. Mesa|Tondo North|Tondo South";
cities[89] = "Bagong Nayon|Barangka|Cogeo|Conception|Conception|Cupang|Industrial Valley|J de la Pena|Langhaya|Malanday|Mambagat|Marikina Heights|Mayamot|Nangka|North/West of Marikina River|Parang|San Roque-Calumpang|Tañong";
cities[90] = "Ayala Alabang Subd.|Bayanan/Putatan|Bule/Cupang|Pearl Heights|Pleasant Village|Poblacion|Susana Heights|Tunasan|Ayala Alabang P.O. Boxes";
cities[91] = "Fish Market|Isla de Cocomo|Kapitbahayan East|Kaunlaran Village|Navotas|Tangos|Tanza";
cities[92] = "Aeropark Subdivision|Baclaran|Better Living Subd.|BF Homes 1|BF Homes 2|Executive Heights Subd.|Ireneville 1 & 3|Ireneville 2|Marina Subd. (Reclamation)|Maywood 1|Maywood 2|Miramar Subd.|Multinational Subd.|Pulo|San Antonio Valley 1|San Antonio Valley 11 & 12|Mervile Park Subd.|Moonwalk Subdivision|South Admiral Village|Santo Niño|Tambo|United Paranaque Subd.";
cities[93] = "San Isidro|San Jose|San Rafael|San Roque|Sta. Clara";
cities[94] = "Caniogan|Kapitolio|Manggahan|Maybunga|Pinagbuhatan|Rosario|San Joaquin|Santolan|Sta. Lucia|Ugong";
cities[95] = "Aguho|Magtanggol|Martires Del 96|Poblacion|San Pedro|San Roque|Sta. Ana|Sto. Rosario - Kanluran|Sto. Rosario - Silangan|Tabacalera";
cities[96] = "Alicia|Amihan|Apolonio Samson|Baesa|Bagbag|Bagong Buhay|Bagong Lipunan|Bagong Pag-asa|Bagong Silangan|Bagong bayan|Bahay Toro|Balingasa|Balintawak|Balumbato|Batasan Hills|Bayanihan|BF Homes|Blue Ridge|Botocan|Bungad|Camp Aguinaldo|Capri|Central|Claro|Commonwealth|Crame|Cubao|Culiat|Damar|Damayan|Damayan Lagi|Damong Maliit|Del Monte|Diliman|Dioquino Zobel|Don Manuel|Dona Aurora|Dona Faustina Subd|Doña Imelda|Dona Josefa|Duyan-Duyan|E. Rodriguez|Escopa|Fairview|Fairview North|Fairview South|Gintong Silahis|Gulod|Holy Spirit|Horseshoe|Immaculate Conception|Kaligayahan|Kalusugan|Kamias|Kamuning|Katipunan|Kaunlaran|Kristong Hari|Krus na Ligas|Laging Handa|La Loma|Libis|Lourdes|Loyola Heights|Maharlica|Malaya|Mangga|Manresa|Mariana|Mariblo|Marilag|Masagana|Masambong|Matalahib|Matandang Balara|Milagrosa|Nagkaisang Nayaon|Nayon Kaunlaran|New Era|Novaliches Town Proper|Obrero|Old Capitol Site|Parang Bundok|Pag-Ibig sa Nayon|Paligsahan|Paltok|Pansol|Paraiso|Pasong Putik|Pasong Tamo|Payatas|Phil-Am / Philam|Pinagkaisahan|Piñahan|Project 4|Project 6|Project 7|Project 8|Quirino District/Project 2 & 3|Ramon Magsaysay|Roxas District|Sacred Heart|San Martin de Porres|Salvacion|San Agustin|San Antonio|San Bartolome|Sangandaan|San Isidro|San Isidro Labrador|San Jose|San Roque|San Vicente|Santa Cruz|Santa Lucia|Santa Monica|Santa Teresita|Santol|Sto. Cristo|Santo Nino|Sauyo|Sienna|Sikatuna Village|Silangan|Socorro|South Triangle|Tagumpay|Talampas|Talayan|Talipapa|Tandang Sora|Tatalon|Teachers Village|Ugong Norte|Unang Sigaw|UP Village|Valencia|Vasra|Veterans Village|Villa Maria Clara|Violago Homes|West Triangle|White Plains";
cities[97] = "San Juan City";
cities[98] = "Bay Breeze Village|Bicutan|Lower Bicutan|Upper Bicutan|Western Bicutan|Ligid|Nichols-Mckinley|Tukukan";
cities[99] = "Arkong Bato|Rincon|Pasolo|Malanday|Mabolo|Polo|Balangkas|Caloong|Dalandan West|Canumay|East Canumay|Lawang Bato Punturin|Fortune Village|Paseo de Blas|Gen. T de Leon|Karuhatan|Lingunan|Mapulang Lupa";

function pop_region(region_id, province_id, city_id,num, region, province, city){
  var regionElement = document.getElementById(region_id);
  regionElement.length=0;
  regionElement.options[0] = new Option('-- Choose a Region --','-1');
  regionElement.selectedIndex = 0;
  for (var i=0; i<regions.length-num; i++) {
    regionElement.options[regionElement.length] = new Option(regions[i],regions[i]);
    if( regions[i]==region ) regionElement.selectedIndex = i+1;
  }
  // Assigned all countries. Now assign event listener for the states.
  if( province_id ){
    pop_province( region_id, province_id, city_id, province, city );
    regionElement.onchange = function(){
      pop_province( region_id, province_id, city_id, province, city );
    };
  }
}

function pop_positions(pos_id, pos_select){
  var positionElement = document.getElementById( pos_id );
  positionElement.length=0;
  positionElement.options[0] = new Option('-- Choose Position --','-1');
  positionElement.selectedIndex = 0;

  var position_arr = positions[1].split("|");
  for (var i=0; i<position_arr.length; i++) {
    positionElement.options[positionElement.length] = new Option(position_arr[i],position_arr[i]);
    if( position_arr[i]==pos_select ) positionElement.selectedIndex = i+1;
  }
}

function pop_province(region_id, province_id, city_id, province, city){
  var selectedRegionIndex = document.getElementById( region_id ).selectedIndex;
  var provinceElement = document.getElementById( province_id );
  
  provinceElement.length=0;  // Fixed by Julian Woods
  provinceElement.options[0] = new Option('-- Choose a Province --','-1');
  provinceElement.selectedIndex = 0;
  
  var province_arr = provinces[selectedRegionIndex].split("|");
  
  for (var i=0; i<province_arr.length; i++) {
    provinceElement.options[provinceElement.length] = new Option(province_arr[i],province_arr[i]);
    if( province_arr[i].toUpperCase()==province.toUpperCase() ) provinceElement.selectedIndex = i+1;
  }

  if( city_id ){
    pop_city( region_id, province_id, city_id, city );
    provinceElement.onchange = function(){
      pop_city( region_id, province_id, city_id, city );
    };
  }
}

function pop_city( region_id, province_id, city_id, city ){
  var selectedRegion = document.getElementById( region_id ).selectedIndex;
  var selectedProvinceIndex = document.getElementById( province_id ).selectedIndex;

  var cityElement = document.getElementById( city_id );
  
  cityElement.length=0;  // Fixed by Julian Woods
  cityElement.options[0] = new Option('-- Choose a Municipality/Barangay --','-1');
  cityElement.selectedIndex = 0;

  var leap = 0;
  for(var j=1; j<selectedRegion; j++){
    var province_arr = provinces[j].split("|");
    leap += province_arr.length;
  }
  leap += selectedProvinceIndex;

  var city_arr = cities[leap].split("|");
  for (var i=0; i<city_arr.length; i++) {
    cityElement.options[cityElement.length] = new Option(city_arr[i].toUpperCase(),city_arr[i].toUpperCase());
    if( city_arr[i].toUpperCase()==city.toUpperCase() ) cityElement.selectedIndex = i+1;
  }
}