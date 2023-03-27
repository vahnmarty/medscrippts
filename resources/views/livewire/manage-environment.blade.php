<div>

    <header class="flex justify-between px-16 py-6 bg-white">
        <div>
            <h1 class="text-3xl font-bold leading-7 text-darkgreen sm:leading-9">Environment</h1>
        </div>
        <div>
            <a href=""  class="btn-primary">
                Force Reload
            </a>
        </div>
    </header>
    
    <div class="px-16 py-12 bg-gray-100">

        <section class="px-3 py-2 mb-8 bg-red-100">
            <pre class="text-sm">If you are knowledgeable to <a href="https://larave.com" class="font-bold" target="_blank">Laravel</a>, you can edit the <strong>.env</strong> and update its variables.</pre>
        </section>
        
        <div class="grid grid-cols-3 gap-8">
            <div>
                <ul role="list" class="bg-white divide-y divide-gray-200 shadow-md ">
                  <li class="">
                    <a href="#app" class="flex px-6 py-4 space-x-3 border-l-4 hover:bg-darkgreen/20 border-darkgreen">
                      <x-heroicon-s-cog class="w-6 h-6 text-gray-600 group-hover:text-white"/>
                      <div class="flex-1 space-y-1">
                        <div class="flex items-center justify-between">
                          <h3 class="text-sm font-medium">App Settings</h3>
                          <p class="text-sm text-gray-500 group-hover:text-white">1 config</p>
                        </div>
                        <p class="text-sm text-gray-500 group-hover:text-white">App general settings</p>
                      </div>
                    </a>
                  </li>

                  <li>
                    <a href="#database" class="flex px-6 py-4 space-x-3 hover:bg-darkgreen/20">
                      <x-heroicon-s-database class="w-6 h-6 text-gray-600 group-hover:text-white"/>
                      <div class="flex-1 space-y-1">
                        <div class="flex items-center justify-between">
                          <h3 class="text-sm font-medium">Database Settings</h3>
                          <p class="text-sm text-gray-500 group-hover:text-white">6 configs</p>
                        </div>
                        <p class="text-sm text-gray-500 group-hover:text-white">Setup your Database configuration</p>
                      </div>
                    </a>
                  </li>

                  <li>
                    <a href="#social" class="flex px-6 py-4 space-x-3 hover:bg-darkgreen/20">
                      <x-heroicon-s-cursor-click class="w-6 h-6 text-gray-600 group-hover:text-white"/>
                      <div class="flex-1 space-y-1">
                        <div class="flex items-center justify-between">
                          <h3 class="text-sm font-medium">Social Media Login</h3>
                          <p class="text-sm text-gray-500 group-hover:text-white">3 configs</p>
                        </div>
                        <p class="text-sm text-gray-500 group-hover:text-white">Security Credentials for Facebook, Twitter and Google.</p>
                      </div>
                    </a>
                  </li>

                </ul>
            </div>

            <div class="col-span-2 space-y-8 ">
                <section id="app">
                    <h3 class="text-xl font-bold text-emerald-800">App Settings</h3>
        
                    <div>
                        <div class="p-6 mt-8 bg-white border rounded-md">
                            
                            <form wire:submit.prevent="saveAppForm">
                                {{ $this->appForm }}
        
                                <button type="submit" class="mt-4 btn-primary btn-sm">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </section>
        
                <section id="database">
                    <h3 class="text-xl font-bold text-emerald-800">Database Settings</h3>
        
                    <div>
                        <div class="p-6 mt-8 bg-white border rounded-md">
                            
                            <form action="">
                                {{ $this->databaseForm }}
        
                                <button type="submit" class="mt-4 btn-primary btn-sm">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </section>
        
                <section id="social">
                    <h3 class="text-xl font-bold text-emerald-800">Social Media Login</h3>
        
                    <div class="space-y-8">
        
                        <div class="p-6 mt-8 bg-white border rounded-md">
                            <h4 class="mb-8 font-bold text-emerald-800">Facebook</h4>
                            <form action="">
                                {{ $this->facebookForm }}
        
                                <button type="submit" class="mt-4 btn-primary btn-sm">Save Changes</button>
                            </form>
                            <div class="px-2 py-1 mt-6 bg-yellow-200">
                                <pre class="text-xs"><strong>Note:</strong> You need to declare your data deletion form on Facebook.</pre>
                            </div>
                        </div>
        
                        <div class="p-6 mt-8 bg-white border rounded-md">
                            <h4 class="mb-8 font-bold text-emerald-800">Twitter</h4>
                            <form action="">
                                {{ $this->twitterForm }}
                                <button type="submit" class="mt-4 btn-primary btn-sm">Save Changes</button>
                            </form>
                        </div>
        
                        <div class="col-span-2 p-6 mt-8 bg-white border rounded-md">
                            <h4 class="mb-8 font-bold text-emerald-800">Google</h4>
                            <form action="">
                                {{ $this->googleForm }}
                                <button type="submit" class="mt-4 btn-primary btn-sm">Save Changes</button>
                            </form>
                        </div>
        
                    </div>
                </section>
            </div>
              
        </div>

        

        
    </div>
</div>
