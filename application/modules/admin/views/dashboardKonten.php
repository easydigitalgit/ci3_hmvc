<div id="dashboardPage" ></div>

 <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-heading p-4">
                    <div>
                        <i style="font-size: 4.5em;color:gray;" class="mdi mdi-account-multiple"></i>
                        <div class="float-right">
                            <h2 id="totalAnggota" class="text-primary mb-0">0</h2>
                            <p class="text-muted mb-0 mt-2">Total Anggota</p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-heading p-4">
                    <div>
                      <i style="font-size: 4.5em;color:gray;"  class="mdi mdi-certificate"></i>
                        <div  class="float-right">
                            <h2 id="totalDPC" class="text-info mb-0">0</h2>
                            <p class="text-muted mb-0 mt-2">Total DPC</p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-heading p-4">
                    <div>
                       <i style="font-size: 4.5em;color:gray;" class="mdi mdi-human-male"></i>
                        <div class="float-right">
                            <h2 id="totalPria" class="text-primary mb-0">0</h2>
                            <p class="text-muted mb-0 mt-2">Total Pria</p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-heading p-4">
                    <div>
                       <i  style="font-size: 4.5em;color:gray;" class="mdi mdi-human-female"> </i>
                        <div class="float-right">
                            <h2 id="totalWanita" class="text-info mb-0">0</h2>
                            <p class="text-muted mb-0 mt-2">Total Wanita</p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>










<div class="row clearfix">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-dark">
                   <strong> Grafik Sebaran Usia Anggota </strong>
                </div>
            </div>
            <div class="card-body">
              <div class="graph" id="area_chart">
                  <canvas id="chart">
                        
                    </canvas>  
                </div>  
            </div>
        </div>
    </div>

    <div class="col-md-4">
     <div class="card">
        <div class=" card-header">
            <div class="card-title text-dark">
               <strong> Sebaran Level Keanggotaan</strong>
            </div>
        </div>
         <div class="card-body">
            <div id="tableSebaran">
                
            </div>
             
         </div>
     </div>
    </div>
        
</div>


<div class="row ">
    <div class="col-md-12">
        
   
    <div class="card">
        <div class=" card-header">
            <div class="card-title text-dark">
            <p>Sebaran Anggota DPC</p>
            </div>
        </div>
        
        <div class="card-body">

            <div class=" col-sm-12">
                
            
            <table class="table table-hover "  id="table_sebaran_anggota_dpc" name="table_sebaran_anggota_dpc" data-source="table_sebaran_anggota_dpc" style="width: 100%;">
              
                <thead>
                    <tr>                 
                        <th width="10%">#</th>
                        <th width="40%">Nama DPC</th>
                        <th width="15%">Pria</th>
                        <th width="15%">Wanita</th>
                        <th width="20%">Total</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            
                      
              
            </table>
            </div>


        </div>
    </div>

    </div> 
</div>