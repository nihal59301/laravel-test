
@if(Auth::user()->usertype!=2)

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
                    <div id="add" class="tabcontent m-2">
                        <x-guest-layout>
                            <form id="ProducteditForm" class="col-12" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input id="editId" name="editId" type="hidden" value="{{$id}}">
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
                                    <x-input-label class="text-start" for="ProductImg" :value="__('Current Image')" />
                                    <image id="editimage" src="" width="80px" height="80px">

                                    <x-input-label class="text-start" for="ProductImg" :value="__('Change Image')" />
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

    $(document).ready(function(){
        var product_id= $("#editId").val();
        axios({
        method:'get',
        url:"getData/"+product_id,
        responseType: 'json',
        }).then(function (response) {
            console.log(response.data.data)
            $("#name").val(response.data.data.name)
            $("#price").val(response.data.data.price)
            $("#model").val(response.data.data.model)
            $("#editimage").attr("src", "../productImage/"+response.data.data.ProductImg);
            $('#ProductImg').text(response.data.data.ProductImg)
            $("#ProductDescription").val(response.data.data.ProductDescription)
            
            
        })

    })
   
    $("#UploadBtn").click(function(){
        $("#ProducteditForm").submit(function(event){
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
        url:"productupdate",
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

    
    </script>