<style>

    .case_history { 
    	height: 32px; 
    	width: 150px; 
    	text-align: center; 
    	padding: 5px; 
    	color: white; 
    	position: absolute;
    	margin-top: 50px;
    	margin-left: -200px;
    }
    
    .text_float { 
		position: absolute;
		margin-top: 55%;
		margin-left: 80px;
		border: 1px solid #D1D1D1;
		padding: 5px 10px;
		-webkit-transform: rotate(270deg);
		-moz-transform: rotate(270deg);
		-o-transform: rotate(270deg);
		transform: rotate(270deg);
		writing-mode: lr-tb;
		font-weight: bold;
	}
    

</style>

<div class="text_float"><h2>Preview</h2></div>

<div class="container">

	<p id="back-top"><a href="#top"><i class="fa fa-arrow-up"></i> Back to Top</a></p>

	<div class="grid">
	<div id="form" class="row">
	
	<div class="logo_header">
		<img src="<?php echo base_url('img/logo_form_header.jpg'); ?>">
	</div>
	
	<div id="form-header" class="col-sm-12 col-md-12 col-lg-12">
	    <h2>CUSTOMER PROFILE</h2>
	</div>
	
	<div class="profile-progress">
	    <h2>APPLICATION PROGRESS STATUS</h2>
	    <div id="appProgress" class="stepper" data-role="stepper" data-steps="3" data-start="1"></div>
	</div>
	 
	<div id="form-frame">
	
	<?php     	
		if(in_array($session_data['role'], array('adminbr_role', 'admin_role'))):
			echo '<div id="check_denied_role" class="row" data-attr="denied"><div class="label error span12" style="padding: 5px 3px; display: none;">ขออภัย, คุณไม่มีสิทธิ์ในการแก้ไขข้อมูล</div></div>';
		endif;
	?>
	
	<article class="row">
	    <div class="span12" style="margin-bottom: 5px;">
	        <h2 class="span12">PROFILE</h2>
	    </div>
	</article>

	<article class="span12">
	    <fieldset>
	        <legend class="span12">Branch Information</legend>
	        <div class="span12">
	            <div class="input-control text span4">
	                <div class="span2">Branch Code</div>
	                <div class="span2"><?php echo !empty($results['data'][0]['BranchCode']) ? str_pad($results['data'][0]['BranchCode'], 3, "0", STR_PAD_LEFT):"000"; ?></div>
	            </div>
	            <div class="input-control text span4">
	                <div class="span1" style="min-width: 85px;">Branch</div>
	                <div class="span2">
	                	<?php $branchName = !empty($results['data'][0]['Branch']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Branch']):""; ?>
	                	<?php 
                        	if($branchName == 'สนับสนุนสาขาสินเชื่อเพื่อรายย่อย' || $branchName == 'สินเชื่อเพื่อรายย่อยสำนักงานใหญ่') echo 'สินเชื่อเพื่อรายย่อย'; 
                            else echo $branchName;
                        ?>
	                </div>
	            </div>
	            <div class="input-control text span4">
	                <div class="span1" style="min-width: 90px;">Region</div>
	                <p class="span2"><?php echo !empty($results['data'][0]['Region']) ? $results['data'][0]['Region']:"-"; ?></p>
	            </div>
	        </div>
	
	        <div class="span12">
	            <div class="input-control text span4">
	                <div class="span2">RM Code</div>
	                <div class="span2"><?php echo !empty($results['data'][0]['RMCode']) ? $results['data'][0]['RMCode']:""; ?></div>
	            </div>
	            <div class="input-control text span4">
	                <div class="span1" style="min-width: 85px;">RM Name</div>
	                <p class="span2" style="min-width: 180px;"><?php echo !empty($results['data'][0]['RMName']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['RMName']):""; ?></p>
	            </div>
	            <div class="input-control text span4">
	                <div class="span1" style="min-width: 95px;">RM Mobile</div>
	                <p class="span2"><?php echo !empty($results['data'][0]['RMMobile']) ? $results['data'][0]['RMMobile']:""; ?></p>
	            </div>
	        </div>
	
	        <div class="span12">
	            <div class="input-control text span4">
	                <div class="span2">BM Name</div>
	                <p class="span2"><?php echo !empty($results['data'][0]['BMName']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['BMName']):"-"; ?></p>
	            </div>
	            
	            <div class="input-control text span8">
	                <div class="span2" style="max-width: 85px">Refer By BM</div>
	                <div class="span6"><?php echo !empty($results['data'][0]['AssignByID']) ? $results['data'][0]['AssignByID']:""; ?><span id="assignname_label"></span></div>
	                <input id="assignname" type="hidden" value="<?php echo !empty($results['data'][0]['AssignByID']) ? $results['data'][0]['AssignByID']:""; ?>">
	            </div>
	            
	        </div>
	        
	        
	    </fieldset>
	</article>
	
	<article class="span12">
	
	<fieldset>
	<legend>Customer Information</legend>
	
	<div class="span12">
        <div class="input-control">
        <label class="span4">Create Date</label>
            <div class="input-control text span4" id="objcreatedate" style="margin-left: 20px;">
               	<input type="text" id="createdate" name="createdate" value="<?php echo !empty($results['data'][0]['CreateDate']) ? StandartDateRollback($results['data'][0]['CreateDate']):""; ?>" disabled="disabled">
                <div class="btn-date"></div>
				</div>
        </div>
    </div>
	
	<?php $customer = !empty($results['data'][0]['SourceOfCustomer']) ? $results['data'][0]['SourceOfCustomer']:""; ?>
	<div class="span12">
	    <div class="input-control text">
	        <label class="span4">Source of customer</label>
	        <div class="span4"><input type="text" value="<?php echo getSourceOfCust($customer); ?>" disabled="disabled"></div>
	    </div>
	</div>
	
	<?php 
	
		function getSourceOfCust($source) {
			if(!empty($source)) {
				switch($source) {
					case 'Field visit': return 'Field visit'; break;
					case 'Loan Top Up': return 'Loan Top Up'; break;
					case 'Call in': return 'Call in'; break;
					case 'Walk in': return 'Walk in'; break;
					case 'Direct mail': return 'Direct mail'; break;
					case 'Telelist': return 'Telelist'; break;
					case 'Refer: Thai Life': return 'Refer by Thai Life'; break;
					case 'Refer: Full Branch': return 'Refer by Full Branch'; break;
					case 'Refer: Call Center': return 'Refer by Call Center'; break;
					case 'Tcrb: Facebook': return 'Refer by TRCB FB'; break;
					case 'Refer: RM': return 'Refer by RM'; break;
					case 'Refer: Customer': return 'Refer by Cust-Suplier'; break;
					case 'Refer: BM': return 'Refer: BM'; break;
					
					case 'Rabbit': return 'Refer by Rabbit'; break;
					case 'Fintech': return 'Refer by Fintech'; break;
					case 'Livechat': return 'Refer by Livechat'; break;
					
					case 'TVC': return 'TVC (โฆษณาทางโทรทัศน์)'; break;
				}
			} else {
				return '';
			}
			
		}
	
	?>
		
	<?php 
	
	$sourceoption = !empty($results['data'][0]['sourceoption']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['sourceoption']):"";
    if($customer == "อื่นๆ") {

        echo "
        <div class=\"span12\">
            <div class=\"input-control textarea\">
                <div class=\"span4\">โปรดระบุ:</div>
                <textarea name=\"sourceoption\" id=\"sourceoption\" class=\"span4\" cols=\"35\" rows=\"3\" style=\"font-size: 0.8em; font-weight: normal;\">".$sourceoption."</textarea>
            </div>
        </div>";
        
    }
	
    ?>
	
	<div class="span12">
        <?php $interest = !empty($results['data'][0]['Interest']) ? $results['data'][0]['Interest']:""; ?>
            <label class="span4">สนใจใช้บริการสินเชื่อ</label>
            <div class="input-control radio" style="margin-left: 20px;">
                <label>
                    <input type="radio" name="interest" value="สนใจ" <?php if($interest == 0) echo "checked"; ?> disabled>
                    <span class="check"></span> สนใจ
                </label>
            </div>
            <div class="input-control radio" style="margin-left: 5px;">
                <label>
                    <input type="radio" name="interest" value="ไม่สนใจ" <?php if($interest == 1) echo "checked"; ?> disabled>
                    <span class="check"></span> ไม่สนใจ
                </label>
            </div>
            <div class="input-control radio hide" style="margin-left: 5px;">
                <label>
                    <input type="radio" name="interest" value="กลับมาสนใจ" <?php if($interest == 2) echo "checked"; ?> disabled>
                    <span class="check"></span> กลับมาสนใจ
                </label>
            </div>
	</div>
	
	<div class="span12">
    		<?php $potential = !empty($results['data'][0]['CSPotential']) ? (int)$results['data'][0]['CSPotential']:""; ?>		
        <div class="input-control radio" data-hint="Customer Potential|ส่วนประเมินลูกค้าว่าอยู่ในเกณฑ์ใด ซึ่งการประเมินนี้ เป็นการประเมินศักยภาพในการทำสินเชื่อของลูกค้าในอนาคต." data-hint-position="right">
            <label class="span4">โอกาสการเป็นลูกค้า</label>
            <div class="input-control radio" style="margin-left: 20px;">
                <label>
                    <input type="radio" name="potential" value="0" <?php if($potential == 0) echo "checked"; ?> disabled="disabled">
                    <span class="check"></span> H
                </label>
            </div>
            <div class="input-control radio" style="margin-left: 27px;">
                <label>
                    <input type="radio" name="potential" value="1" <?php if($potential == 1) echo "checked"; ?> disabled="disabled">
                    <span class="check"></span> M
                </label>
            </div>
            <div class="input-control radio" style="margin-left: 40px;">
                <label>
                    <input type="radio" name="potential" value="2" <?php if($potential == 2) echo "checked"; ?> disabled="disabled">
                    <span class="check"></span> L
                </label>
            </div>
        </div>
 	</div>
 	
 	<div class="span12">
 		<?php $load_group = !empty($results['data'][0]['LoanGroup']) ? $results['data'][0]['LoanGroup']:""; ?>		
        <div class="input-control radio">
            <label class="span4">ประเภทสินเชื่อที่นำเสนอ</label>
            <div class="input-control radio" style="margin-left: 20px;" data-hint="Nano Finance" data-hint-position="right">
                <label>
                    <input type="radio" name="loan_group" value="NN" <?php if($load_group == 'NN') echo "checked"; ?> disabled="disabled">
                    <span class="check"></span> NN
                </label>
            </div>
            <div class="input-control radio" style="margin-left: 17px;" data-hint="Micro Finance" data-hint-position="right">
                <label>
                    <input type="radio" name="loan_group" value="MF" <?php if($load_group == 'MF') echo "checked"; ?> disabled="disabled">
                    <span class="check"></span> MF
                </label>
            </div>	    
			<div class="input-control radio" style="margin-left: 33px;" data-hint="Small Business Loan" data-hint-position="right">
                <label>
                    <input type="radio" name="loan_group" value="SB" <?php if($load_group == 'SB') echo "checked"; ?> disabled="disabled">
                    <span class="check"></span> SB
                </label>
            </div>
             <div class="input-control radio" style="margin-left: 33px;" data-hint="Micro SME" data-hint-position="right">
                <label>
                    <input type="radio" name="loan_group" value="MF SME" <?php if($load_group == 'MF SME') echo "checked"; ?> disabled="disabled">
                    <span class="check"></span> MF SME
                </label>
            </div>   
            <span id="loan_gruop_alert" class="marginLeft20 text-alert"></span>
        </div>
    </div>
	
	<div class="span12">
	    <div class="input-control text">
	        <?php $ownertype = !empty($results['data'][0]['OwnerType']) ? $results['data'][0]['OwnerType']:""; ?>
	        <div class="input-control text" style="margin: 10px 0;">
	            <div class="span4">
	                <div class="span4">
	                    <div class="input-control radio" style="margin-top: -20px;">
	                        <label class="span4">
	                            <input name="ownertype" type="radio" value="ชื่อเจ้าของกิจการ" <?php if($ownertype == 0) echo "checked"; ?> disabled>
	                            <span class="check"></span> ชื่อเจ้าของกิจการ
	                        </label>
	                        <label class="span4" style="margin-left: 1px;">
	                            <input name="ownertype" type="radio" value="ชื่อผู้ติดต่อ" <?php if($ownertype == 1) echo "checked"; ?> disabled>
	                            <span class="check"></span> ชื่อผู้ติดต่อ
	                        </label>
	                    </div>
	                </div>
	            </div>
	            <div class="span4">
	            	<?php $prefixname = !empty($results['data'][0]['PrefixName']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['PrefixName']):""; ?>
	            	<?php $ownername = !empty($results['data'][0]['OwnerName']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['OwnerName']):""; ?>
	            	<input type="text" value="<?php echo $prefixname.' '.$ownername;  ?>" disabled="disabled">
	            	<input id="owner" type="hidden" value="<?php echo $ownername; ?>">
	            </div>
	        </div>
	    </div>
	</div>
	
	<div class="span12" style="margin-top: 3px;">
	    <div class="input-control text">
	        <div class="span4">ชื่อสถานที่ประกอบการ</div>
	        <div class="span4">
	        	<?php $prefixcorp = !empty($results['data'][0]['PrefixCorp']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['PrefixCorp']):""; ?>
	        	<?php $company 	  = !empty($results['data'][0]['Company']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Company']):""; ?>
	        	<input type="text" value="<?php echo $prefixcorp.' '.$company; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">ประเภทธุรกิจ</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['BusinessType']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['BusinessType']):""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">ธุรกิจ / กิจการเกี่ยวกับ</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['Business']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Business']):""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">เบอร์ติดต่อ (สำนักงาน)</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['Telephone']) ? $results['data'][0]['Telephone']:""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">เบอร์ติดต่อ 2</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['Mobile']) ? $results['data'][0]['Mobile']:""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">ย่านธุรกิจ</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['Downtown']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Downtown']):""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12">
	    <div id="textarea_add" class="input-control text">
	        <div class="span4">ที่อยู่</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['Address']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Address']):""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">จังหวัด</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['Province']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Province']):""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">อำเภอ</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['District']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['District']):""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">รหัสไปรษณีย์</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['Postcode']) ? $results['data'][0]['Postcode']:""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">รับทราบจากช่องทางสื่อ</div>
	        <div class="span4" data-hint="<?php echo !empty($results['data'][0]['SubChannel']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['SubChannel']):""; ?>" data-hint-position="right">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['SubChannel']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['SubChannel']):""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	
	<div class="span12">
	    <div class="input-control text">
	         <div class="span4">ประเภทช่องทางสื่อ</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['Channel']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['Channel']):""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">วงเงินที่ต้องการ (บาท)</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['RequestLoan']) ? number_format($results['data'][0]['RequestLoan'], 0):""; ?>" disabled="disabled">
	        </div>
	    </div>
	</div>
	
	<div class="span12" style="display: none;">
	    <div class="input-control text">
	        <div class="span4">วันนัดพบครั้งถัดไป</div>
	        <div class="span4">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['Subject']) ? $this->effective->get_chartypes($char_mode,  $results['data'][0]['Subject']):""; ?>" disabled="disabled">
	        </div>
	        <div class="span2">
	        	<input type="text" value="<?php echo !empty($results['data'][0]['DueDate']) ? StandartDateRollback($results['data'][0]['DueDate']):""; ?>" disabled="disabled">
	        </div>
	        <div class="input-control checkbox">
	        	<?php $endEvent = (int)!empty($results['data'][0]['IsRepeat']) ? $results['data'][0]['IsRepeat']:""; ?>
				<label style="margin-left: 5px; margin-top: 2px;">
					<input type="checkbox" name="endevent" id="endevent" value="1" <?php if($endEvent == 1) echo "checked"; ?> disabled>
					<span class="check"></span> <i class="fa fa-bell-slash-o"></i> End Event
				</label>
			</div>
	    </div>
	</div>
	
	<div class="span12">
		 <?php $criteria = !empty($results['data'][0]['BasicCriteria']) ? intval($results['data'][0]['BasicCriteria']):""; ?>
    	<label class="span4">Basic Criteria <span class="text-warning"><small>(กรุณีลูกค้าไม่ผ่านเกณฑ์เบื้องต้นคลิก)</small></span></label>
       	<div class="input-control checkbox span1" >
        <label>
        	<input type="checkbox" id="criteria" name="criteria" value="1" <?php if(intval($criteria) == 0) echo "checked"; ?> disabled="disabled">
        	<span class="check"></span>
        </label>
        </div>
        <div class="input-control text span4" style="margin-left: -30px; max-width: 270px;">
            <input type="text" value="<?php echo !empty($results['data'][0]['CriteriaReason']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['CriteriaReason']):""; ?>" disabled="disabled">
        </div>
	</div>
	
	<div class="span12">
	    <div class="input-control text">
	        <div class="span4">Refer by TL Agent</div>
	        <div class="span4">
	        	<input id="referralcode" type="text" value="<?php echo !empty($results['data'][0]['ReferralCode']) ? $results['data'][0]['ReferralCode']:""; ?>" disabled="disabled">
	        </div>
	        <span id="parent-pop-async" class="span1"><i id="show-pop-async" class="ti-id-badge fg-darkCyan" style="font-size: 1.4em; cursor: pointer;"></i></span>
	    </div>
	</div>
	
	<div class="span12">
	    <div class="input-control textarea">
	        <div class="span4">Remark</div>
	        <div class="span4">
	        	<textarea disabled="disabled"><?php echo !empty($results['data'][0]['Remark']) ? $this->effective->get_chartypes($char_mode, $results['data'][0]['Remark']):""; ?></textarea>
	        </div>
	    </div>
	</div>
	
	</fieldset>
	</article>
	</div>
	
	<div id="form_footer"><img src="<?php echo base_url('img/logo_form_footer.jpg'); ?>" style="margin-top: 50px;"></div>
		

</div>
</div>
</div>
<?php

function StandartDateRollback($date) {
    if($date == "") {
        return "";

    } else {

        $spl = explode("-", $date);

        $y = $spl[0];
        $m = $spl[1];
        $d = $spl[2];

        return "$d/$m/$y";

    }

}

?>

<script type="text/javascript">

var pathArray = window.location.pathname.split( '/'), newPathname = window.location.protocol + "//" + window.location.host;
var pathFixed = window.location.protocol + "//" + window.location.host;
for (var i = 0; i < (pathArray.length -1); i++ ) { newPathname += pathArray[i]; newPathname += "/"; }
for (var i = 0; i < (pathArray.length -2); i++ ) { pathFixed += pathArray[i]; pathFixed += "/"; }

$('#parent-pop-async').click(function() {

	var tl_agent_code = $('#referralcode').val();
	if(tl_agent_code == '') {
		var not = $.Notify({ content: "กรุณากรอกรหัส Referral Code", style: { background: '#A20025 ', color: '#FFFFFF' }, timeout: 10000 });
		not.close(7000);
	}
	 
});

$('#parent-pop-async').hover(function() {
	
	var tl_agent_code = $('#referralcode').val();
	if(tl_agent_code != '') {
		
		var settings = {
				trigger:'click',
				width: 'auto',						
				multi:true,						
				closeable: false,
				style:'',
				delay:300,
				padding: true,
				backdrop:false
		};

		
		var asyncSettings = {	
			width:'auto',
			height:'auto',
			closeable: false,
			padding:false,
			cache:false,
			url: pathFixed + 'dataloads/getTLADataDetail?_='  + new Date().getTime() + '&tl_ref=' + tl_agent_code + '&getdesc=true',	
			type:'async',
			content: function(data) {

				if(data['status']) {
					var html = 
						'<table class="table table-bordered">' +
							'<thead>' +
								'<tr>' +
									'<th colspan="4">THAI LIFE AGENT</th>' +
								'</tr>' +
								'<tr style="background-color: #3175AF; color: #FFF;">' +
									'<th class="text-center">CODE</th>' +
									'<th class="text-center">NAME</th>' +
									'<th class="text-center">BRANCH</th>' +
									'<th class="text-center">POSITION</th>' +
									'<th class="text-center">MOBILE</th>' +
								'</tr>' +
							'</thead>' +
							'<tbody>' +
								'<td>' + data['data'][0]['TLA_Code'] + '</td>' +
								'<td>' + data['data'][0]['TLA_Name'] + '</td>' +
								'<td>' + data['data'][0]['TLA_Position'] + '</td>' +
								'<td>' + data['data'][0]['TLA_BranchName'] + '</td>' +
								'<td>' + data['data'][0]['TLA_Mobile'] + '</td>' +
							'</tbody>' +
						'</table>';

						return html;
				} else {
					return 'ไม่พบข้อมูล';
				}

			}
		};
				
		$('#show-pop-async').webuiPopover('destroy').webuiPopover($.extend({}, settings, asyncSettings));
		
	} 
	
}); 

</script>
