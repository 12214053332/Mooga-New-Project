				<?php foreach($messagelist as $message){
							$message = (object) $message
				?>
		<div class="row hidden-md hidden-lg">

		   <div class="col-md-1 col-lg-1 col-sm-1 col-xs-1 text-center">
				<input type="checkbox" class="snd-msg-checkbox">
		   </div>
		   <div class="col-md-11 col-lg-11 col-sm-11 col-xs-11">
				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 bg-gry mrg-btm-twenty">
					<div class="row">
						<div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
							<img src="<?php echo $message->profilepic; ?>" class="img-responsive img-message">
						</div>
						<div class="col-md-9 col-lg-9 col-sm-9 col-xs-9 no-pdg-lft">
							<a href="?page=readmessage&mid=<?php echo $message->id; ?>">
								<p class="pnl-name sm-title-name"><?php echo $message->name; if($message->related>0){echo' ( '.$message->related.' ) ';}?></p>
								<p class="pnl-left message-date sm-title-name"><?=$message->msgtime?></p>
								<p class="message-body"><b><?php echo $message->title; ?></b> - <?=$helper->__html($message->message,15, array('html' => true, 'ending' => '...'))?></p>
							</a>
						</div>
					</div>
				</div>
		   </div>
		</div>
		
					
					<?php } ?>

				<style>
					table>tbody>tr {
						border-right: 6px solid #ffffff;
					}
					table>tbody>tr:not(.notHover):hover{
						border-right: 6px solid #d4d4d4;
						background: #f7f7f7;
					}
					.unread{
						font-weight: bold;
						font-size: 13pt;
						background: #ececec;
					}
				</style>
				<div class="container hidden-xs hidden-sm">
					<div class="row">
						<div class="box-body no-padding">
							<hr>
							<div class="table-responsive mailbox-messages">
								<table class="table table-responsive">
									<tbody>
									<?php if(count($messagelist)==0){?>
											<tr class="notHover">
												<td colspan="6" class="text-center">لا توجد رسائل</td>
											</tr>
									<?php }else{?>
									<?php foreach($messagelist as $message){
										$message = (object) $message;
									?>
										<tr <?php if($message->readmsg==0){echo'class="unread"';}?>style="cursor: pointer;"  data-link="?page=readmessage&mid=<?php echo $message->id; ?>">
											<td style="vertical-align: inherit;"><input type="checkbox"></td>
											<td class="openMessage"><a href="?page=readmessage&mid=<?php echo $message->id; ?>"><img src="<?php echo $message->profilepic; ?>" class="img-responsive img-message"></a></td>
											<td style="vertical-align: inherit;" class="mailbox-name openMessage"><a href="?page=readmessage&mid=<?php echo $message->id; ?>"><?php echo $message->name;if($message->related>0){echo' ( '.$message->related.' ) ';}?></a></td>
											<td style="vertical-align: inherit;" class="mailbox-subject openMessage"><b><?php echo $message->title; ?></b> - <?=$helper->__html($message->message,15, array('html' => true, 'ending' => '...'))?></td>
											<td style="vertical-align: inherit;" class="mailbox-attachment openMessage"></td>
											<td style="vertical-align: inherit;" class="mailbox-date openMessage"><?=$message->msgtime?></td>
										</tr>
									<?php }}?>
									</tbody>
								</table><!-- /.table -->
							</div><!-- /.mail-box-messages -->
						</div><!-- /.box-body -->
						<hr>
					</div><!-- /. box -->
				</div><!-- /.col -->
				</div><!-- /.row -->
				</div>
				</div>
				<script>
					$(document).on('click','.openMessage',function(){
						link=$(this).parent().attr('data-link');
						window.location=link;
					});
				</script>