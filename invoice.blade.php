
<!DOCTYPE html>
<html>
<head>

  <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    

</head>
<body>
   <center>
    <div class="container">
        <h2 style="margin:5px">Invoice </h2><br>
        <!-- @if($errors->any())
        <div>
          <ul>
              @foreach($errors->all() as $err)
              <li>{{$err}}</li>
              @endforeach
            </ul>
        </div>
        @endif -->
        
                <form method="post" id="frm"  action="">
                  
                    <!-- @csrf -->

                <div>Select user :
                         <select id="username" name="username" style="width: 200px";>
                            <option value="">All user</option>
                           @foreach($name as $nam) 
                	
                 
                	<option value="{{$nam->id}}">{{$nam->name}} </option>
                    @endforeach

                </select></div>
                      
                      <span style="color: red" id="usernameError"></span>
                <br>
                <div>Date :  
                         <input type="date" id="date"  name="date" style="width: 200px";>
                </div>
                   <span style="color:red" id="dateError"></span>
                <br>
                <br>
                <div>Amount :
                         <input type="text" id="amount" name="amount" style="width: 200px"; >
                </div>

                 <span style="color: red" id="amountError" ></span>
                  <br>
                  <br>

                <div>Description :
                        <textarea name="description" id="description" style="width: 200px";></textarea></div>
                        <span style="color: red" id="descriptionError"></span>
                  
                        <br>
                        <br>
                    
                    <div>
                        <input type="hidden" id="id" name="id" value="0">
                        <input type="hidden" id=userid  name="userid">
                        <button type="button" id="bttn" value="submit">submit</button></div><br>
      
                  
                  
      </form>
      <table border="1"  width="350px" height="100px" class="table" id="tbl">
        <thead>
          <tr>
            <th>Userid</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Description</th>
            <th colspan="2">Operations</th>
          </tr>
        </thead>
        <tbody id="users">
               
        </tbody>
        </table>
      </div>
    </center>
           
      <script>  

                   load();
                 function load(){
                        
                        $.ajax({
                          url:'/getuser',
                          type:'GET',
                          success:function(response){
                            data =response.data;
                            $("#users tr").remove();
                          // console.log(data);

                     for (var i=0;i<response.data.length;i++){
                        
                           $("#users").append('<tr class="tr"><td>'+data[i].user_id+'</td><td>'
                                  +data[i].date+'</td><td>'
                                 +data[i].amount+'</td><td>'
                                    +data[i].description+'</td><td><button type="button"  class=" del" data-id="'+data[i].id+'">Delete</button></td><td><button type="button"  class=" edt" data-id="'+data[i].id+'">Edit</button></td></tr>');
                         }
                      }
                    });
                      }
                        
                        




                        $(document).ready(function(){
                    $("#bttn").click(function(response){
                                event.preventDefault();
                                $.ajaxSetup({
                                headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                  });
                          var id=$("#id").val();
                      
                           if(id==0)
                           {
                        
                                  $.ajax({
                                  url:'/insertuser',
                                  type:'post',
                                  data:$("#frm").serialize(),
                                 
                                  success:function (data) {
                                    load();

                                   // $("#users").append('<tr class="tr"><td>'+data['data']['user_id']+'</td><td>'
                                   //  +data['data']['date']+'</td><td>'
                                   //  +data['data']['amount']+'</td><td>'
                                   //  +data['data']['description']+'</td><td><button type="button"  class=" del" data-id="'+data['data']['user_id']+'">Delete</button></td><td><button type="button"  class=" edt" data-id="'+data['data']['user_id']+'">Edit</button></td></tr>');
                                      
                                 // console.log(data['data']['user_id']);
                                          

                                         
                                   
                                       $("#frm :input").each(function(){
                                        $(this).val('');
                                   });
                                   },
                                   error: function(response){
                                    let errors=response.responseJSON.errors;
              if(errors.username){
              $('#usernameError').text(errors.username);
            }
            else{
              $('#usernameError').text("");
            }
            if(errors.date){
              $('#dateError').text(errors.date);
            }
            else{
              $('#dateError').text("");
            }
            if(errors.amount){
              $('#amountError').text(errors.amount);
            }
            else{
                  $('#amountError').text("");
            }
            if(errors.description){
              $('#descriptionError').text(errors.description);
            }
          else{
                $('#descriptionError').text("");
          }
            
            }
              // console.log(errors.username);
              
                                  
                     });
                               
                      }


                                 else{

                                       $.ajax({
                                  url:"updateuser",
                                  type:"GET",
                                  data:$("#frm").serialize(),
                                  success:function(data){
                                    load();
                              
                                    $("#frm")[0].reset();
                                    $("#id").val(0);
                                  }
                                });
                                
                                }
                       });

             $(document).on('click', '.edt', function(){ 
                 var id=$(this).data("id"); 
           $("#id").val(id);

                               $.ajax({
                                  url:"userr/"+id,
                                  type:"GET",
                                  data:$("#frm").serialize(),
                                  success:function(data){
                                  
                                    // var row=$(this); 
                                    // console.log(data.data);
           
                                   $("#username").val(data.data.userId);
                                   $("#date").val(data.data.date);
                                   $("#amount").val(data.data.amount);
                                   $("#description").val(data.data.description);

                              
                                   
                                  }
                                });


                          });


                


                  $(document).on('click', '.del', function(response){ 
                 event.preventDefault(); 
                  var id=$(this).data("id"); 
                 var whichtr = $(this).closest("tr");
                 // alert(id); 
                 if(confirm("Are you sure you want to delete this?"))  
                 {  
                 $.ajax({  
                     url:"/deletedata",  
                     method:"GET",  
                     data:{id:id},  
                      
                     success:function(data){ 
                       load();
                      
                         whichtr.remove();
                     
                          
                     }  
               });  
          }  
      }); 










                  });


                              
                              
                                   
                       
             
    </script> 
            
           

    </body>
    </html>

