<?php

require("api/base_support.php");
$er_langpackage=new rechargelp;

$dbo = new dbex;
//��д���붨�庯��
dbtarget('w',$dbServs);

	print_r($dbo);

	function kq_ck_null($kq_va,$kq_na){if($kq_va == ""){return $kq_va="";}else{return $kq_va=$kq_na.'='.$kq_va.'&';}}
	//����������˺ţ����˺�Ϊ11λ����������̻����+01,��ֵ���ύʱ��ͬ��
	$kq_check_all_para=kq_ck_null($_REQUEST[merchantAcctId],'merchantAcctId');
	//���ذ汾���̶�ֵ��v2.0,��ֵ���ύʱ��ͬ��
	$kq_check_all_para.=kq_ck_null($_REQUEST[version],'version');
	//�������࣬1����������ʾ��2����Ӣ����ʾ��Ĭ��Ϊ1,��ֵ���ύʱ��ͬ��
	$kq_check_all_para.=kq_ck_null($_REQUEST[language],'language');
	//ǩ������,��ֵΪ4������PKI���ܷ�ʽ,��ֵ���ύʱ��ͬ��
	$kq_check_all_para.=kq_ck_null($_REQUEST[signType],'signType');
	//֧����ʽ��һ��Ϊ00���������е�֧����ʽ�����������ֱ���̻�����ֵΪ10,��ֵ���ύʱ��ͬ��
	$kq_check_all_para.=kq_ck_null($_REQUEST[payType],'payType');
	//���д��룬���payTypeΪ00����ֵΪ�գ����payTypeΪ10,��ֵ���ύʱ��ͬ��
	$kq_check_all_para.=kq_ck_null($_REQUEST[bankId],'bankId');
	//�̻������ţ�,��ֵ���ύʱ��ͬ��
	$kq_check_all_para.=kq_ck_null($_REQUEST[orderId],'orderId');
	//�����ύʱ�䣬��ʽ��yyyyMMddHHmmss���磺20071117020101,��ֵ���ύʱ��ͬ��
	$kq_check_all_para.=kq_ck_null($_REQUEST[orderTime],'orderTime');
	//����������ԡ��֡�Ϊ��λ���̻�������1�ֲ��Լ��ɣ������Դ������,��ֵ��֧��ʱ��ͬ��
	$kq_check_all_para.=kq_ck_null($_REQUEST[orderAmount],'orderAmount');
	// ��Ǯ���׺ţ��̻�ÿһ�ʽ��׶����ڿ�Ǯ����һ�����׺š�
	$kq_check_all_para.=kq_ck_null($_REQUEST[dealId],'dealId');
	//���н��׺� ����Ǯ����������֧��ʱ��Ӧ�Ľ��׺ţ��������ͨ�����п�֧������Ϊ��
	$kq_check_all_para.=kq_ck_null($_REQUEST[bankDealId],'bankDealId');
	//��Ǯ����ʱ�䣬��Ǯ�Խ��׽��д����ʱ��,��ʽ��yyyyMMddHHmmss���磺20071117020101
	$kq_check_all_para.=kq_ck_null($_REQUEST[dealTime],'dealTime');
	//�̻�ʵ��֧����� �Է�Ϊ��λ���ȷ�10Ԫ���ύʱ���ӦΪ1000���ý������̻���Ǯ�˻������յ��Ľ�
	$kq_check_all_para.=kq_ck_null($_REQUEST[payAmount],'payAmount');
	//���ã���Ǯ��ȡ�̻��������ѣ���λΪ�֡�
	$kq_check_all_para.=kq_ck_null($_REQUEST[fee],'fee');
	//��չ�ֶ�1����ֵ���ύʱ��ͬ
	$kq_check_all_para.=kq_ck_null($_REQUEST[ext1],'ext1');
	//��չ�ֶ�2����ֵ���ύʱ��ͬ��
	$kq_check_all_para.=kq_ck_null($_REQUEST[ext2],'ext2');
	//�������� 10֧���ɹ���11 ֧��ʧ�ܣ�00��������ɹ���01 ��������ʧ��
	$kq_check_all_para.=kq_ck_null($_REQUEST[payResult],'payResult');
	//������� ������ա���������ؽӿ��ĵ�����󲿷ֵ���ϸ���͡�
	$kq_check_all_para.=kq_ck_null($_REQUEST[errCode],'errCode');

	$ordernumber=$_REQUEST[orderId];

	$trans_body=substr($kq_check_all_para,0,strlen($kq_check_all_para)-1);
	$MAC=base64_decode($_REQUEST[signMsg]);

	$fp = fopen("action/chongzhi/kuaipay/99bill.cert.rsa.20340630.cer", "r"); 
	$cert = fread($fp, 8192); 
	fclose($fp); 
	$pubkeyid = openssl_get_publickey($cert); 
	$ok = openssl_verify($trans_body, $MAC, $pubkeyid); 
	
	

	if ($ok == 1) { 
		switch($_REQUEST[payResult]){
				case '10':
						//�˴����̻��߼�����
						
						 $sql2="SELECT * FROM wy_balance WHERE ordernumber = '".$ordernumber."'";
                        //$row = $this->dsql->getRow($sql);
                        $row=$dbo->getRow($sql2);
                        //print_r($row);exit();
                        if($row['state'] != '2' || $row['state'] != 2)
                        {
                            $sql = "UPDATE wy_balance SET `state`='2' WHERE ordernumber = '{$ordernumber}'";
                        }
                        
                        
                        if($dbo->exeUpdate($sql))
                        {
                            if(empty($row['touid']))
                            {
                                $uid=$row['uid'];
                                $sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='$uid'";
                                //echo $sql;
                                
                            }
                            else
                            {
                                $touid=$row[touid];
                                $sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='$touid'";
                                //echo $sql;
                                
                            }
                            if(!$dbo->exeUpdate($sql)){
                        
								$msg="��ӽ��ʧ��";
                              
                            }else{
								$msg="�����ҳɹ�";
							}
        
                        } else {
                           
							$msg="sql���ִ��ʧ�ܣ�";
                        }
						
						$rtnOK=1;
						//���������ǿ�Ǯ���õ�showҳ�棬�̻���Ҫ�Լ������ҳ�档
						$rtnUrl="http://www.missinglovelove.com/do.php?act=kshow&msg=$msg";
						break;
				default:
						$rtnOK=1;
						//���������ǿ�Ǯ���õ�showҳ�棬�̻���Ҫ�Լ������ҳ�档
						$rtnUrl="http://www.missinglovelove.com/do.php?act=kshow&msg=false";
						break;	
		
		}

	}else{
						$rtnOK=1;
						//���������ǿ�Ǯ���õ�showҳ�棬�̻���Ҫ�Լ������ҳ�档
						$rtnUrl="http://www.missinglovelove.com/do.php?act=kshow&msg=error";
							
	}

	//echo $ordernumber;

?>

<result><?PHP echo $rtnOK; ?></result> <redirecturl><?PHP echo $rtnUrl; ?></redirecturl>