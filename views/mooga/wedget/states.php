<option value=""></option>
  <?php
 
 $selected="";
			foreach ($states as $state) {
				$id=$state['id'];
				$name=$state['name'];
				if($selectedvalue ==$id)
				{
					$selected='selected';
				}else{$selected='';}
				echo " <option value='$id' $selected>$name</option> ";
			}
 ?>