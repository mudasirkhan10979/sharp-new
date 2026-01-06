<?php
####################################################
#	SpiralClick Custom Framework Based web App     #
####################################################
#Declare the Global variables:
?>
<div class="sidebar-widget">
    <h3>Feedback</h3>
    <p>If something is not right, you want to ask us a question or you just want to get something off your chest, feel free to get in touch</p>
    <div class="leave-a-comment">
        <form name="frmFeedback" action="feedback"  method="post" >
        <textarea name="feedback_msg"
            onfocus="if (this.value==this.defaultValue) this.value = ''"
            onblur="if (this.value=='') this.value = this.defaultValue"
            >Please write your feedback</textarea>
        <div class="right">
            <input class="theme-btn" type="submit" value="Submit">
        </div>
        </form>
    </div>
</div>