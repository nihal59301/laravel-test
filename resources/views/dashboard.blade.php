
@if(Auth::user()->usertype!=3)
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
                    <p>{{'This is user Page'}}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@else
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($data as $item)
                    <div class="p-10" style="text-align: -webkit-center;">
                        <!--Card 1-->
                        <div class=" w-full lg:max-w-sm ">
                          <div class="h-48 lg:h-auto flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('/mountain.jpg')" title="Mountain">
                          </div>
                          <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                            <div class="mb-8">
                              <p class="text-sm text-gray-600 flex items-center">
                                <svg class="fill-current text-gray-500 w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                  <path d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z" />
                                </svg>
                                For User only
                              </p>
                              <div class="text-gray-900 font-bold text-xl mb-2">{{$item->name}}</div>
                              <p class="text-gray-700 text-base">{{$item->ProductDescription}}</p>
                            </div>
                            <div class="flex items-center">
                              <img class="w-20 h-20 rounded-full mr-4" src="productImage/{{$item->ProductImg}}" alt="Avatar of Writer">
                              <div class="text-sm">
                                <p class="text-gray-900 leading-none font-bold ">MODEL :-{{$item->model}}</p>
                                <p class="text-gray-800 font-bold">PRICE :-{{$item->price}}</p>
                              </div>
                            </div>
                            
                          </div>                          
                        </div>
                        
                      </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


@endif