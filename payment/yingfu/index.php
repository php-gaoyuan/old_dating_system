<?php
header("content-type:text/html;charset=utf-8");
require("../../foundation/asession.php");
require("../../configuration.php");
require("../../includes.php");
require("../../{$langPackageBasePath}/paymentlp.php");
$paymentlp = new paymentlp();

//读写分离定义函数
$dbo = new dbex;
dbtarget('w', $dbServs);
$order_no = $_GET["oid"];
$pt = $_GET["pt"];
$user_id = get_sess_userid();

$sql = "select * from wy_balance where uid={$user_id} and ordernumber='{$order_no}' and type='{$pt}'";
$order = $dbo->getRow($sql,"arr");
if(empty($order)){
    header("location:/");exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $paymentlp->title;?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
<div class="container">
    <div class="py-2 text-center">
        <h2><?php echo $paymentlp->title;?></h2>
    </div>
    <hr class="mb-4">
    <div class="row">
        <div class="col-md-12 order-md-1">
            <form class="needs-validation" method="post" id="payForm" action="./pay.php" novalidate>
                <div class="info-wrap">
                    <div class="row">
                        <div class="col-md-6 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->order_no;?></span>
                                </div>
                                <input type="text" class="form-control" name="product" id="product" value="<?php echo $_REQUEST['oid'];?>" required readonly>
                                <input type="hidden" name="oid" value="<?php echo $_REQUEST['oid'];?>">
                                <input type="hidden" name="pt" value="<?php echo $_REQUEST['pt'];?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->amount;?></span>
                                </div>
                                <input type="text" class="form-control" name="amount" id="amount" value="<?php echo $_REQUEST['am'];?>USD"  required readonly>
                                <input type="hidden" name="currency" value="USD">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3 text-center">
                        <h4><?php echo $paymentlp->bill_info;?></h4>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->ming;?></span>
                                </div>
                                <input type="text" class="form-control" id="firstname" name="billing_first_name" required>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->xing;?></span>
                                </div>
                                <input type="text" class="form-control" id="lastname" name="billing_last_name" required>
                            </div>
                        </div>
                    </div>
                    <!--                -->
                    <div class="row">
                        <div class="col-md-6 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->email;?></span>
                                </div>
                                <input type="text" class="form-control" name="billing_email" id="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3 offset-md-3">
                            <select class="custom-select d-block w-100" name="billing_country" id="country" required>
                                <option value="CN">China</option>
                                <option value="AF">Afghanistan</option>
                                <option value="AL">Albania</option>
                                <option value="AD">Andorra</option>
                                <option value="AO">Angola</option>
                                <option value="AM">Armenia</option>
                                <option value="AW">Aruba</option>
                                <option value="AU">Australia</option>
                                <option value="AE">United Arab Emirates</option>
                                <option value="AR">Argentina</option>
                                <option value="AG">Antigua and Barbuda</option>
                                <option value="AT">Austria</option>
                                <option value="AZ">Azerbaijan</option>
                                <option value="AN">Netherlands Antilles</option>
                                <option value="BB">Barbados</option>
                                <option value="BD">Bangladesh</option>
                                <option value="BE">Belgium</option>
                                <option value="BZ">Belize</option>
                                <option value="BJ">Benin</option>
                                <option value="BT">Bhutan</option>
                                <option value="BO">Bolivia</option>
                                <option value="BA">Bosnia and Herzegovina</option>
                                <option value="BW">Botswana</option>
                                <option value="BN">Brunei</option>
                                <option value="BG">Bulgaria</option>
                                <option value="BH">Bahrain</option>
                                <option value="BM">Bermuda</option>
                                <option value="BR">Brazil</option>
                                <option value="BS">Bahamas</option>
                                <option value="BF">Burkina Faso</option>
                                <option value="BI">Burundi</option>
                                <option value="CM">Cameroon</option>
                                <option value="CA">Canada</option>
                                <option value="CV">Cape Verde</option>
                                <option value="CF">Central African Republic</option>
                                <option value="KM">Comoros</option>
                                <option value="CG">Congo</option>
                                <option value="CH">Switzerland</option>
                                <option value="CL">Chile</option>
                                <option value="CO">Colombia</option>
                                <option value="CR">Costa Rica</option>
                                <option value="CY">Cyprus</option>
                                <option value="CZ">Czech Republic</option>
                                <option value="DE">Germany</option>
                                <option value="DK">Denmark</option>
                                <option value="DJ">Djibouti</option>
                                <option value="DZ">Algeria</option>
                                <option value="DO">Dominican Republic</option>
                                <option value="EC">Ecuador</option>
                                <option value="EG">Egypt</option>
                                <option value="ER">Eritrea</option>
                                <option value="EE">Estonia</option>
                                <option value="ET">Ethiopia</option>
                                <option value="ES">Spain</option>
                                <option value="EH">Western Sahara</option>
                                <option value="FJ">Fiji</option>
                                <option value="FR">France</option>
                                <option value="FI">Finland</option>
                                <option value="GF">French Guiana</option>
                                <option value="GA">Gabon</option>
                                <option value="GM">Gambia</option>
                                <option value="GE">Georgia</option>
                                <option value="GH">Ghana</option>
                                <option value="GI">Gibraltar</option>
                                <option value="GD">Grenada</option>
                                <option value="GR">Greece</option>
                                <option value="GP">Guadeloupe</option>
                                <option value="GT">Guatemala</option>
                                <option value="GY">Guyana</option>
                                <option value="GW">Guinea-Bissau</option>
                                <option value="GB">United Kingdom</option>
                                <option value="HT">Haiti</option>
                                <option value="HN">Honduras</option>
                                <option value="HK">Hong Kong</option>
                                <option value="HU">Hungary</option>
                                <option value="ID">The Republic of Indonesia</option>
                                <option value="IE">Ireland</option>
                                <option value="IL">Israel</option>
                                <option value="IN">India</option>
                                <option value="IS">Iceland</option>
                                <option value="IT">Italy</option>
                                <option value="JM">Jamaica</option>
                                <option value="JP">Japan</option>
                                <option value="JO">Jordan</option>
                                <option value="KZ">Kazakhstan</option>
                                <option value="KE">Kenya</option>
                                <option value="KG">Kyrgyzstan</option>
                                <option value="KR">Korea</option>
                                <option value="KW">Kuwait</option>
                                <option value="KN">Saint Kitts and Nevis</option>
                                <option value="LB">Lebanon</option>
                                <option value="LY">Libyan Arab Jamahiriya</option>
                                <option value="LI">Liechtenstein</option>
                                <option value="LK">Sri Lanka</option>
                                <option value="LT">Lithuania</option>
                                <option value="LU">Luxembourg</option>
                                <option value="LV">Latvia</option>
                                <option value="LC">Saint Lucia</option>
                                <option value="MC">Monaco</option>
                                <option value="MO">Macau</option>
                                <option value="Mk">Macedonia</option>
                                <option value="MG">Madagascar</option>
                                <option value="MW">Malawi</option>
                                <option value="MV">Maldives</option>
                                <option value="ML">Mali</option>
                                <option value="MT">Malta</option>
                                <option value="MQ">Martinique</option>
                                <option value="MR">Mauritania</option>
                                <option value="MU">Mauritius</option>
                                <option value="MX">Mexico</option>
                                <option value="MY">Malaysia</option>
                                <option value="MD">Moldova</option>
                                <option value="MN">Mongolia</option>
                                <option value="MA">Morocco</option>
                                <option value="MZ">Mozambique</option>
                                <option value="NA">Namibia</option>
                                <option value="NP">Nepal</option>
                                <option value="NL">Netherlands</option>
                                <option value="NI">Nicaragua</option>
                                <option value="NE">Niger</option>
                                <option value="NG">Nigeria</option>
                                <option value="NO">Norway</option>
                                <option value="NZ">New Zealand</option>
                                <option value="OM">Oman</option>
                                <option value="PK">Pakistan</option>
                                <option value="PA">Panama</option>
                                <option value="PG">Papua New Guinea</option>
                                <option value="PY">Paraguay</option>
                                <option value="PE">Peru</option>
                                <option value="PH">Philippines</option>
                                <option value="PL">Poland</option>
                                <option value="PT">Portugal</option>
                                <option value="QA">Qatar</option>
                                <option value="RO">Romania</option>
                                <option value="RU">Russian Federation</option>
                                <option value="RW">Rwanda</option>
                                <option value="SM">San Marino</option>
                                <option value="ST">Sao Tome and Principe</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="SN">Senegal</option>
                                <option value="RS">Serbia</option>
                                <option value="SZ">Swaziland</option>
                                <option value="SC">Seychelles</option>
                                <option value="SL">Sierra Leone</option>
                                <option value="SO">Somalia</option>
                                <option value="SR">Suriname</option>
                                <option value="SE">Sweden</option>
                                <option value="SG">Singapore</option>
                                <option value="SK">Slovakia</option>
                                <option value="SI">Slovenia</option>
                                <option value="SV">El Salvador</option>
                                <option value="SY">Syrian Arab Republic</option>
                                <option value="TJ">Tajikistan</option>
                                <option value="TZ">Tanzania</option>
                                <option value="TH">Thailand</option>
                                <option value="TG">Togo</option>
                                <option value="TN">Tunisia</option>
                                <option value="TR">Turkey</option>
                                <option value="TT">Trinidad and Tobago</option>
                                <option value="TW">Taiwan, Province of China</option>
                                <option value="TM">Turkmenistan</option>
                                <option value="TC">Turks and Caicos Islands</option>
                                <option value="UG">Uganda</option>
                                <option value="UA">Ukraine</option>
                                <option value="US">United States</option>
                                <option value="UY">Uruguay</option>
                                <option value="UZ">Uzbekistan</option>
                                <option value="VE">Venezuela</option>
                                <option value="VC">Saint Vincent and the Grenadines</option>
                                <option value="VN">Vietnam</option>
                                <option value="YE">Yemen</option>
                                <option value="ZM">Zambia</option>
                                <option value="ZA">South Africa</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->province;?></span>
                                </div>
                                <input type="text" class="form-control" name="billing_state" id="state" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->city;?></span>
                                </div>
                                <input type="text" class="form-control" name="billing_city" id="city" required>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->zipcode;?></span>
                                </div>
                                <input type="text" class="form-control" name="billing_postal_code" id="postcode" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->address;?></span>
                                </div>
                                <input type="text" class="form-control" name="billing_address" id="address" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->phone;?></span>
                                </div>
                                <input type="text" class="form-control" name="billing_phone" id="phone" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-block my-3 gateway-sele offset-md-3">
                        <div class="custom-control custom-radio">
                            <input id="pro" name="shipping" value="pro"
                                   type="radio" class="custom-control-input">
                            <label class="custom-control-label" for="pro"><?php echo $paymentlp->ship_address;?>?</label>
                        </div>
                    </div>
                    <div class="shippinginfo" style="display: none;">
                        <div class="col-md-12 mb-3 text-center">
                            <h4><?php echo $paymentlp->ship_info;?></h4>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3 offset-md-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $paymentlp->ming;?></span>
                                    </div>
                                    <input type="text" class="form-control shipping" id="shippingFirstname" name="shipping_first_name">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $paymentlp->xing;?></span>
                                    </div>
                                    <input type="text" class="form-control shipping" id="shippingLastname" name="shipping_last_name">
                                </div>
                            </div>
                        </div>
                        <!--                -->
                        <div class="row">
                            <div class="col-md-6 mb-3 offset-md-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $paymentlp->email;?></span>
                                    </div>
                                    <input type="text" class="form-control shipping" name="shippingEmail" id="shipping_email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3 offset-md-3">
                                <select class="custom-select d-block w-100 shipping" name="shipping_country" id="shippingCountry">
                                    <option value="CN">China</option>
                                    <option value="AF">Afghanistan</option>
                                    <option value="AL">Albania</option>
                                    <option value="AD">Andorra</option>
                                    <option value="AO">Angola</option>
                                    <option value="AM">Armenia</option>
                                    <option value="AW">Aruba</option>
                                    <option value="AU">Australia</option>
                                    <option value="AE">United Arab Emirates</option>
                                    <option value="AR">Argentina</option>
                                    <option value="AG">Antigua and Barbuda</option>
                                    <option value="AT">Austria</option>
                                    <option value="AZ">Azerbaijan</option>
                                    <option value="AN">Netherlands Antilles</option>
                                    <option value="BB">Barbados</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="BE">Belgium</option>
                                    <option value="BZ">Belize</option>
                                    <option value="BJ">Benin</option>
                                    <option value="BT">Bhutan</option>
                                    <option value="BO">Bolivia</option>
                                    <option value="BA">Bosnia and Herzegovina</option>
                                    <option value="BW">Botswana</option>
                                    <option value="BN">Brunei</option>
                                    <option value="BG">Bulgaria</option>
                                    <option value="BH">Bahrain</option>
                                    <option value="BM">Bermuda</option>
                                    <option value="BR">Brazil</option>
                                    <option value="BS">Bahamas</option>
                                    <option value="BF">Burkina Faso</option>
                                    <option value="BI">Burundi</option>
                                    <option value="CM">Cameroon</option>
                                    <option value="CA">Canada</option>
                                    <option value="CV">Cape Verde</option>
                                    <option value="CF">Central African Republic</option>
                                    <option value="KM">Comoros</option>
                                    <option value="CG">Congo</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="CL">Chile</option>
                                    <option value="CO">Colombia</option>
                                    <option value="CR">Costa Rica</option>
                                    <option value="CY">Cyprus</option>
                                    <option value="CZ">Czech Republic</option>
                                    <option value="DE">Germany</option>
                                    <option value="DK">Denmark</option>
                                    <option value="DJ">Djibouti</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="DO">Dominican Republic</option>
                                    <option value="EC">Ecuador</option>
                                    <option value="EG">Egypt</option>
                                    <option value="ER">Eritrea</option>
                                    <option value="EE">Estonia</option>
                                    <option value="ET">Ethiopia</option>
                                    <option value="ES">Spain</option>
                                    <option value="EH">Western Sahara</option>
                                    <option value="FJ">Fiji</option>
                                    <option value="FR">France</option>
                                    <option value="FI">Finland</option>
                                    <option value="GF">French Guiana</option>
                                    <option value="GA">Gabon</option>
                                    <option value="GM">Gambia</option>
                                    <option value="GE">Georgia</option>
                                    <option value="GH">Ghana</option>
                                    <option value="GI">Gibraltar</option>
                                    <option value="GD">Grenada</option>
                                    <option value="GR">Greece</option>
                                    <option value="GP">Guadeloupe</option>
                                    <option value="GT">Guatemala</option>
                                    <option value="GY">Guyana</option>
                                    <option value="GW">Guinea-Bissau</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="HT">Haiti</option>
                                    <option value="HN">Honduras</option>
                                    <option value="HK">Hong Kong</option>
                                    <option value="HU">Hungary</option>
                                    <option value="ID">The Republic of Indonesia</option>
                                    <option value="IE">Ireland</option>
                                    <option value="IL">Israel</option>
                                    <option value="IN">India</option>
                                    <option value="IS">Iceland</option>
                                    <option value="IT">Italy</option>
                                    <option value="JM">Jamaica</option>
                                    <option value="JP">Japan</option>
                                    <option value="JO">Jordan</option>
                                    <option value="KZ">Kazakhstan</option>
                                    <option value="KE">Kenya</option>
                                    <option value="KG">Kyrgyzstan</option>
                                    <option value="KR">Korea</option>
                                    <option value="KW">Kuwait</option>
                                    <option value="KN">Saint Kitts and Nevis</option>
                                    <option value="LB">Lebanon</option>
                                    <option value="LY">Libyan Arab Jamahiriya</option>
                                    <option value="LI">Liechtenstein</option>
                                    <option value="LK">Sri Lanka</option>
                                    <option value="LT">Lithuania</option>
                                    <option value="LU">Luxembourg</option>
                                    <option value="LV">Latvia</option>
                                    <option value="LC">Saint Lucia</option>
                                    <option value="MC">Monaco</option>
                                    <option value="MO">Macau</option>
                                    <option value="Mk">Macedonia</option>
                                    <option value="MG">Madagascar</option>
                                    <option value="MW">Malawi</option>
                                    <option value="MV">Maldives</option>
                                    <option value="ML">Mali</option>
                                    <option value="MT">Malta</option>
                                    <option value="MQ">Martinique</option>
                                    <option value="MR">Mauritania</option>
                                    <option value="MU">Mauritius</option>
                                    <option value="MX">Mexico</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="MD">Moldova</option>
                                    <option value="MN">Mongolia</option>
                                    <option value="MA">Morocco</option>
                                    <option value="MZ">Mozambique</option>
                                    <option value="NA">Namibia</option>
                                    <option value="NP">Nepal</option>
                                    <option value="NL">Netherlands</option>
                                    <option value="NI">Nicaragua</option>
                                    <option value="NE">Niger</option>
                                    <option value="NG">Nigeria</option>
                                    <option value="NO">Norway</option>
                                    <option value="NZ">New Zealand</option>
                                    <option value="OM">Oman</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="PA">Panama</option>
                                    <option value="PG">Papua New Guinea</option>
                                    <option value="PY">Paraguay</option>
                                    <option value="PE">Peru</option>
                                    <option value="PH">Philippines</option>
                                    <option value="PL">Poland</option>
                                    <option value="PT">Portugal</option>
                                    <option value="QA">Qatar</option>
                                    <option value="RO">Romania</option>
                                    <option value="RU">Russian Federation</option>
                                    <option value="RW">Rwanda</option>
                                    <option value="SM">San Marino</option>
                                    <option value="ST">Sao Tome and Principe</option>
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SN">Senegal</option>
                                    <option value="RS">Serbia</option>
                                    <option value="SZ">Swaziland</option>
                                    <option value="SC">Seychelles</option>
                                    <option value="SL">Sierra Leone</option>
                                    <option value="SO">Somalia</option>
                                    <option value="SR">Suriname</option>
                                    <option value="SE">Sweden</option>
                                    <option value="SG">Singapore</option>
                                    <option value="SK">Slovakia</option>
                                    <option value="SI">Slovenia</option>
                                    <option value="SV">El Salvador</option>
                                    <option value="SY">Syrian Arab Republic</option>
                                    <option value="TJ">Tajikistan</option>
                                    <option value="TZ">Tanzania</option>
                                    <option value="TH">Thailand</option>
                                    <option value="TG">Togo</option>
                                    <option value="TN">Tunisia</option>
                                    <option value="TR">Turkey</option>
                                    <option value="TT">Trinidad and Tobago</option>
                                    <option value="TW">Taiwan, Province of China</option>
                                    <option value="TM">Turkmenistan</option>
                                    <option value="TC">Turks and Caicos Islands</option>
                                    <option value="UG">Uganda</option>
                                    <option value="UA">Ukraine</option>
                                    <option value="US">United States</option>
                                    <option value="UY">Uruguay</option>
                                    <option value="UZ">Uzbekistan</option>
                                    <option value="VE">Venezuela</option>
                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                    <option value="VN">Vietnam</option>
                                    <option value="YE">Yemen</option>
                                    <option value="ZM">Zambia</option>
                                    <option value="ZA">South Africa</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $paymentlp->province;?></span>
                                    </div>
                                    <input type="text" class="form-control shipping" name="shipping_state" id="shippingState">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3 offset-md-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $paymentlp->city;?></span>
                                    </div>
                                    <input type="text" class="form-control shipping" name="shipping_city" id="shippingCity">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $paymentlp->zipcode;?></span>
                                    </div>
                                    <input type="text" class="form-control shipping" name="shippingPostcode" id="shippingPostcode">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3 offset-md-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $paymentlp->address;?></span>
                                    </div>
                                    <input type="text" class="form-control shipping" name="shipping_address" id="shippingAddress">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3 offset-md-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo $paymentlp->phone;?></span>
                                    </div>
                                    <input type="text" class="form-control shipping" name="shipping_phone" id="shippingPhone">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 隐藏域，获取session_id -->
                    <input type="hidden" id="session_id" name="session_id" value="">

                    <div class="container-fluid py-3">
                        <div class="row">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-4 mx-auto">
                                <div id="pay-invoice" class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h3 class="text-center"><?php echo $paymentlp->card_info;?></h3>
                                        </div>
                                        <hr>
                                        <div class="form-group text-center">
                                            <ul class="list-inline">
                                                <!--img-->
                                                <li class="list-inline-item"><img src="img/visa.png"></li>
                                                <li class="list-inline-item"><img src="img/master.png"> </li>
                                                <li class="list-inline-item"><img src="img/jcb.png"></li>
                                                <li class="list-inline-item"><img src="img/ae.png"></li>
                                            </ul>
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-number" class="control-label mb-1"><?php echo $paymentlp->card_number;?></label>
                                            <input id="cc-number" name="cardNum" type="tel" class="form-control cc-number identified visa" required="" onblur="validateCreditCard()" pattern="[0-9]{16}">
                                            <span class="invalid-feedback">Enter a valid 16 digit card number</span>
                                            <span class="invalid-feedback cardnumerror" style="display:none;">Please enter a valid card number</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="cc-exp" class="control-label mb-1"><?php echo $paymentlp->year;?></label>
                                                    <select class="custom-select d-block w-100" name="year" id="year" required>
                                                        <?php
                                                        for($i = 0;$i<10;$i++){
                                                            $date = date('Y')+$i;
                                                            echo  '<option value="'.$date.'">'.$date.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="cc-exp" class="control-label mb-1"><?php echo $paymentlp->month;?></label>
                                                <select class="custom-select d-block w-100" name="month" id="month" required>
                                                    <option value="01">1</option>
                                                    <option value="02">2</option>
                                                    <option value="03">3</option>
                                                    <option value="04">4</option>
                                                    <option value="05">5</option>
                                                    <option value="06">6</option>
                                                    <option value="07">7</option>
                                                    <option value="08">8</option>
                                                    <option value="09">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">CVV</label>
                                            <input id="cc-payment" name="cvv" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                        </div>
                                        <div>
                                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                <i class="fa fa-lock fa-lg"></i>&nbsp;
                                                <span id="payment-button-amount"><?php echo $paymentlp->btn_pay;?></span>
                                                <span id="payment-button-sending" style="display:none;">Sending…</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.bundle.js"></script>
<script src="https://stage-js.wintopay.com/js/shield"></script>
<script type="text/javascript">

    let session_id = wintopayShield.getSessionId();
    $('#session_id').val(session_id);

    var selected = 0;
    $(".gateway-sele input[name='shipping']").on("click", function (e) {
        if(selected == 0){
            selected = 1;
            $('.shipping').attr("required", "true");
            $('.shippinginfo').show();
        }else{
            selected=0;
            $('.shipping').removeAttr('required');
            $('.shippinginfo').hide();
            $(this).prop('checked', false);
            $(this).data('checked', false);
        }
    });

    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    $("#payment-button").click(function(e) {
        // Fetch form to apply Bootstrap validation
        var form = $(this).parents('form');

        if (form[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        }
        else {
            // Perform ajax submit here
            form.submit();
        }

        form.addClass('was-validated');
    });
    //验证卡号是否符合规则
    function validateCreditCard() {
        var s = $('#cc-number').val();
        var v = '0123456789',
            w = '',
            i, j, k, m, c, a, x;
        for (i = 0; i < s.length; i++) {
            x = s.charAt(i);
            if (v.indexOf(x, 0) !== -1) {
                w += x;
            }
        }
        // validate number
        j = w.length / 2;
        k = Math.floor(j);
        m = Math.ceil(j) - k;
        c = 0;

        for (i = 0; i < k; i++) {
            a = w.charAt(i * 2 + m) * 2;
            c += a > 9 ? Math.floor(a / 10 + a % 10) : a;
        }

        for (i = 0; i < k + m; i++) {
            c += w.charAt(i * 2 + 1 - m) * 1;
        }
        var result =  c % 10 === 0;
        if(!result){
            $('.cardnumerror').show();
            $('#payment-button').attr('disabled','true');
        }else{
            $('.cardnumerror').hide();
            $('#payment-button').removeAttr('disabled');
        }
    }
    function totalChange(){
        var total = $('#amount').val();
        $('#payment-button-amount').text('Pay $'+total);
    }
</script>
</body>
</html>