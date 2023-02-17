
@if(Auth::user()->usertype!=2)
<style>
    * {box-sizing: border-box}
    
    /* Set height of body and the document to 100% */
    body, html {
      height: 100%;
      margin: 0;
      font-family: Arial;
    }
    
    /* Style tab links */
    .tablink {
      background-color: #555;
      color: white;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      font-size: 17px;
      width: 25%;
    }
    
    .tablink:hover {
      background-color: #777;
    }
    
    /* Style the tab content (and add height:100% for full page content) */
    .tabcontent {
      color: white;
      display: none;
      padding: 100px 20px;
      height: 100%;
    }
    .card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.price {
  color: grey;
  font-size: 22px;
}


.card {
  width: 220px;
  float: left;
  margin: 1rem;
  border: 1px solid #d3d3d3;
  padding: 20px;
  border-radius: 5px;
  background-color: white;
}

@supports (display: grid) {
  .cards {
    margin: 0;
  }
  .cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    grid-gap: 1rem;
  }
}

#uploadedproduct_length{
color: red;
}
td{
    text-align: -webkit-center !important;
}


</style>
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
                    <p>{{'This is Seller Page'}}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@else
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" >
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    <button id="productlist" class="tablink" onclick="openPage('list', this, 'red')">Product List</button> |
                    <button  class="tablink" onclick="openPage('add', this, 'green')" id="defaultOpen">Add Product</button>
                    {{-- <button class="tablink" onclick="openPage('Contact', this, 'blue')">Contact</button>
                    <button class="tablink" onclick="openPage('About', this, 'orange')">About</button> --}}
                    
                    <div id="list"  class="tabcontent">
                        <input type="hidden" id="userid" value="{{Auth::user()->id}}">
                        <table id="uploadedproduct" width="100%" class="">
                            <thead>
                                <tr>
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
                        <x-guest-layout>
                            <form id="ProductForm" class="col-12" method="POST" enctype="multipart/form-data">
                                @csrf
                        
                                <!-- Name -->
                                <div>
                                    <x-input-label class="text-start" for="name" :value="__('Product Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <!-- Price -->
                                <div>
                                    <x-input-label class="text-start" for="price" :value="__('Product Price')" />
                                    <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')" required autofocus autocomplete="price" />
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>
                                <!-- Model -->
                                <div>
                                    <x-input-label class="text-start" for="model" :value="__('Product Model')" />
                                    <x-text-input id="model" class="block mt-1 w-full" type="text" name="model" :value="old('model')" required autofocus autocomplete="model" />
                                    <x-input-error :messages="$errors->get('model')" class="mt-2" />
                                </div>
                                <!-- file -->
                                <div>
                                    <x-input-label class="text-start" for="ProductImg" :value="__('Product Image')" />
                                    <x-input-file id="ProductImg" class="block mt-1 w-full" type="file" name="ProductImg" :value="old('ProductImg')" required autofocus autocomplete="ProductImg" />
                                    <x-input-error :messages="$errors->get('ProductImg')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label class="text-start mt-3" for="ProductDescription" :value="__('Product Description')" />
                                    <x-textarea id="ProductDescription" class="block mt-1 w-full" type="textarea" name="ProductDescription" :value="old('ProductDescription')" required autofocus autocomplete="ProductDescription" />
                                    <x-input-error :messages="$errors->get('ProductDescription')" class="mt-2" />
                                </div>
                                <div class="flex items-center justify-center mt-4">
                                    <button id="UploadBtn" class="ml-4 border rounded p-2">
                                        {{ __('Upload') }}
                                    </button>
                                </div>
                            </form>

                        </x-guest-layout>
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


    $("#UploadBtn").click(function(){
        $("#ProductForm").submit(function(event){
		submitForm();
		return false;
	});
    function submitForm(){
        //console.log(document.lookup.name.value)
        var formEl = document.forms.ProductForm;
        var formData = new FormData(formEl);
        formData.append('user_id', {{Auth::user()->id}})
        //console.log(name)
        //console.log($('form#lookupForm').serialize())
        console.log('form submitted')

        axios({
        method: 'post',
        url:"product",
        responseType: 'json',
        data: formData
        })
        .then(function (response) {
              console.log(response.data)
              if(response.data.status=='Success'){
                Swal.fire(
                  'Product Uploaded!',
                  '',
                  'success'
                  ).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                      location.reload();
                  }
                  })
              }
              if(response.data.errors.ProductImg=='error'){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                    }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                  }
                  })
              }
              
        });       
    }
    })

    $("#productlist").click(function(){
        var user_id=$("#userid").val();
        var formData = new FormData();
        formData.append('user_id', {{Auth::user()->id}})
        axios({
        method: 'post',
        url:"productlist",
        responseType: 'json',
        data: formData
        })
        .then(function (response) {
            console.log(response.data.data)  
            var count=0;

            var project_table =$('#uploadedproduct').DataTable({     
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
                                    '<svg onclick="edit('+row.id+')"  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg>'+
                                '<svg onclick="trash('+row.id+')" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16"><path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/></svg>'+
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

    })
    function edit(product_id){
        window.location ='/editProduct/'+product_id;
        }


    function trash(product_id){
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
    </script>