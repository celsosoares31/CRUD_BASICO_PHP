<?php

function print_error($message, $status)
{
    echo "<div  class='myToast mytoastDiv'>
            <div class='position-absolute end-0 m-2 p-2 w-25 bg-$status'>
              <div class='toast-body'> 
              $message
                <button type='button' onclick='closeMyToast(this);'><i class='fa-solid fa-xmark'></i></button>
              </div>
            </div>
          </div>
        ";
}
