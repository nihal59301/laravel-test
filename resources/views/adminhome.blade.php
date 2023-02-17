<style>
    td{
        text-align: -webkit-center;
        color: white
    }
</style>
@if(Auth::user()->usertype!=1)
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Access Denied') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{'You Dont Have Premission To Access This Page'}}
                    <p>{{'This is admin Page'}}</p>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@else
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" >
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    <button id="productBtn" class="tablink" onclick="openPage('list', this, 'red')">Product List</button> |
                    <button  class="tablink" onclick="openPage('add', this, 'green')" id="defaultOpen">User List</button>
                    {{-- <button class="tablink" onclick="openPage('Contact', this, 'blue')">Contact</button>
                    <button class="tablink" onclick="openPage('About', this, 'orange')">About</button> --}}
                    
                    <div id="list"  class="tabcontent">
                        <input type="hidden" id="userid" value="1">
                        <table id="producttable" width="100%" class="text-white">
                            <thead>
                                <tr >
                                    <th>Product Nama</th>
                                    <th>Model</th>
                                    <th>Price</th> 
                                    <th>Image</th> 
                                    <th>Action</th> 
              
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        
                    </div>
                    
                    <div id="add" class="tabcontent m-2">
                        
                            <input type="hidden" id="userid" value="2">
                            <table id="usertable" width="100%" class="text-white">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>User Type</th> 
                                        <th>Create Date</th> 
                                        <th>Action</th> 
                  
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                    </div>
                    
                    {{-- <div id="Contact" class="tabcontent">
                      <h3>Contact</h3>
                      <p>Get in touch, or swing by for a cup of coffee.</p>
                    </div>
                    
                    <div id="About" class="tabcontent">
                      <h3>About</h3>
                      <p>Who we are and what we do.</p>
                    </div> --}}
                    
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endif
<script>
    $(document).ready(function(){
        axios({
        method: 'get',
        url:"userlist",
        responseType: 'json',
        })
        .then(function (response) {
            console.log(response.data.data)  
            var count=0;

            var project_table =$('#usertable').DataTable({     
              data: response.data.data,
              "aaSorting": [],
              destroy: true,
              "language": {
                    "lengthMenu": "show _MENU_ only",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "searchPlaceholder": "Search",
                    "search":"_INPUT_",     
                }, 
              columnDefs: [
                
                {
                      targets:0, // Start with the last
                      render: function ( data, type, row, meta ) {
                        // console.log(data)
                                count=count+1; 
                                return count;
                      }
                  }, 
                  {
                      targets:1, // Start with the last
                      render: function ( data, type, row, meta ) {
                          if(type === 'display'){
                                data='<p>' + row.name + '</p>'
                          }
                          return data;
                      }
                  }, 
                  {
                      targets:2, // Start with the last
                      render: function ( data, type, row, meta ) { 
                          if(type === 'display'){
                                
                                  data=row.email;
                            
                          }
                          return data;
                      }
                  },  
                  {
                      targets:3, // Start with the last
                      render: function ( data, type, row, meta ) {
                        if(type === 'display'){ 
                                    if(row.usertype==2){
                                        data ='Seller'  
                                    }
                                    else{
                                        data ='User'  
                                    }                     
                                                      
                          }
                          return data;
                      }
                  }, 
                  {
                      targets:4, // Start with the last
                      render: function ( data, type, row, meta ) {
                        if(type === 'display'){                              
                              data =row.created_at                         
                          }
                          return data;
                      }
                  }, 
                  {
                      targets:5, // Start with the last
                      render: function ( data, type, row, meta ) {             

                                data='<div  id="actiontd" style="-webkit-writing-mode: vertical-lr;">'+
                                '<svg onclick="trashuser('+row.id+')" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16"><path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/></svg>'+
                                '</div>';
                            
                            return data;
                      }
                  },                        
              ] , 
              columns: [                
                  { data: 'count'  },
                  { data: 'name'},
                  { data: 'email'  },
                  { data: 'usertype'  },          
                  { data: 'created_at'  }
              ],
              
                 
          });  
    
        });
    })
    function openPage(pageName,elmnt,color) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
      }
      document.getElementById(pageName).style.display = "block";
      elmnt.style.backgroundColor = color;
    }
    
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
    

    $("#productBtn").click(function(){
        var data=$("#userid").val();
        if(data==1){
        axios({
        method: 'get',
        url:"itemlist",
        responseType: 'json',
        })
        .then(function (response) {
            console.log(response.data.data)  
            var count=0;
            var project_table =$('#producttable').DataTable({     
              data: response.data.data,
              "aaSorting": [],
              destroy: true,
              "language": {
                    "lengthMenu": "show _MENU_ only",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "searchPlaceholder": "Search",
                    "search":"_INPUT_",     
                }, 
              columnDefs: [
                
                {
                      targets:0, // Start with the last
                      render: function ( data, type, row, meta ) {
                        // console.log(data)
                                count=count+1; 
                                return count;
                      }
                  }, 
                  {
                      targets:1, // Start with the last
                      render: function ( data, type, row, meta ) {
                          if(type === 'display'){
                                data='<p>' + row.model + '</p>'
                          }
                          return data;
                      }
                  }, 
                  {
                      targets:2, // Start with the last
                      render: function ( data, type, row, meta ) { 
                          if(type === 'display'){
                                
                                  data=row.price;
                            
                          }
                          return data;
                      }
                  },  
                  {
                      targets:3, // Start with the last
                      render: function ( data, type, row, meta ) {
                        if(type === 'display'){                              
                              data ='<div class="row" style="text-align: -webkit-center;"><img src="productImage/'+row.ProductImg+'" alt="'+row.name+'" width="50" height="50"></div>'                          
                          }
                          return data;
                      }
                  }, 
                  {
                      targets:4, // Start with the last
                      render: function ( data, type, row, meta ) {             

                                data='<div id="actiontd" style="-webkit-writing-mode: vertical-lr;">'+
                                '<svg onclick="trashproduct('+row.id+')" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16"><path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/></svg>'+
                                '</div>';
                            
                            return data;
                      }
                  },                        
              ] , 
              columns: [                
                  { data: 'count'  },
                  { data: 'name'},
                  { data: 'model'  },
                  { data: 'price'  },          
                  { data: 'id'  }
              ],
              
                 
          });  
    
        });
        }

        
        

        })

        


    function trashproduct(product_id){
        var formData = new FormData();
        formData.append('product_id', product_id)
        axios({
        method: 'post',
        url:"productdelete",
        responseType: 'json',
        data: formData
        }).then(function (response) {
            console.log(response.data)
            if(response.data==1){

                Swal.fire(
                  'Product Deleted!',
                  '',
                  'success'
                  ).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                      location.reload();
                  }
                  })

            }
        })
    }
    function trashuser(user_id){
        var formData = new FormData();
        formData.append('user_id', user_id)
        axios({
        method: 'post',
        url:"deleteuser",
        responseType: 'json',
        data: formData
        }).then(function (response) {
            console.log(response.data)
            if(response.data==1){

                Swal.fire(
                  'User Deleted!',
                  '',
                  'success'
                  ).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                      location.reload();
                  }
                  })

            }
        })
    }
</script>

