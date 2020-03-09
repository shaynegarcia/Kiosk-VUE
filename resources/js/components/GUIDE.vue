<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                   <div class="card-header">
                        <h3 class="card-title no-print">Dashboard</h3>
                         </div>
                            <div class="card-body">
                                    <ul class="nav nav-pills">
                                        <li v-show="!tabActive" class="nav-item no-print"><a class="nav-link active" href="#scans" data-toggle="tab">Scans</a></li>
                                        <li v-show="!tabActive" class="nav-item no-print "><a class="nav-link" href="#items" data-toggle="tab">Items</a></li>
                                        <li v-show="!tabActive" class="nav-item no-print"><a class="nav-link" href="#reports" data-toggle="tab">Invoice</a></li>
                                        <!-- <li class="nav-item no-print"><a class="nav-link" href="#print" data-toggle="tab">Print</a></li> -->
                                        <!-- <li class="nav-item no-print"><a class="nav-link" href="#monthly" data-toggle="tab">Monthly</a></li> -->
                                    </ul>
                             </div>
                     <div class="tab-content">
                                <!-- Scans TAB-->
                    <div class="active tab-pane" id="scans">
                                <h1  align="center">Scan Items</h1>
                            <div class="card-body">
                                <div class="col-12">
                                    <form class="form-horizontal" @submit.prevent="">
                                        <div class="row">
                                            <div title="Focus here" class="col-sm-10">
                                            <label>SKU/UPC</label>  &nbsp; <i class="fas fa-question-circle" data-toggle="modal" data-target="#scanfocusModal"></i>
                                                    <div class="form-group">
                                                        <input type="text" ref="scanner" class="form-control" id="inputSKU" placeholder="SKU/UPC"  @keydown.enter="scanItems"  v-model="sku_input" autocomplete="off">
                                                            <!-- <has-error :form="form" field="name"></has-error> -->
                                                    </div>
                                                </div>
                                            <div class="col-sm-2">
                                                <label>Quantity</label>
                                                    <div class="form-group">
                                                        <!-- <select class="custom-select" v-model="qty_input" onfocusout="this.$refs.scanner.focus()">
                                                        <option> 1</option>
                                                        <option> 2</option>
                                                        <option> 3</option>
                                                        <option> 4</option>
                                                        <option> 5</option>
                                                        </select>
                                                         -->
                                                        <input type="number" class="form-control" v-model="qty_input" onfocusout="this.$refs.scanner.focus()">
                                                    </div>
                                                </div>
                                                    <div class="col-sm-12">
                                                        <div class="card-body table-responsive p-0" id="scantable">
                                                                <!-- scan items start -->
                                                                <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                    <th>SKU/UPC</th>
                                                                    <th>Description</th>
                                                                    <th>Quantity</th>
                                                                    <th>Price</th>
                                                                    <th>Remarks</th>
                                                                    <th> Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(item, index) in scanned_items" :key="'item' + index">
                                                                        <td align="center">{{ item.sku_upc }}</td>
                                                                    <td align="center">{{ item.description }}</td>
                                                                    <td align="center">{{ item.qty }}
                                                                        <i class="fas fa-plus green" @click="scannedItemAddQty(index)"></i>
                                                                                 |
                                                                        <i class="fas fa-minus orange" @click="scannedItemMinusQty(index)"></i></td>
                                                                    <td align="center">${{ parseFloat(item.price).toFixed(2) }}</td>
                                                                    <td align="center">{{item.remarks}}</td>
                                                                    <td align="center">
                                                                                 <i class="fas fa-edit blue" @click="getSelectedItemIdForRemarks(index)"></i>
                                                                                 |
                                                                                <i class="fas fa-trash red" @click="removeRow(index)"></i>

                                                                    </td>
                                                                    </tr>
                                                                </tbody>
                                                                </table>
                                                            <!-- scan items end -->
                                                        </div>
                                                        </div>
                                                    </div>
                                                <div class="card-body footer">
                                                    <div class="col-sm-offset-5 col-sm-10">
                                                        <button type="button" class="btn btn-primary" v-if="!isHidden" :disabled="loading" @click="checkout">Checkout <i class="fas fa-shopping-cart"></i></button>   <label v-if="!isHidden" >Total Price: $ {{ this.total_price }}</label>
                                                    </div>
                                            </div>
                                        </form>
                            <!-- /.card -->
                                    </div>
                                </div>
                           <!-- Info scan focus Modal -->
                    <div class="modal fade" id="scanfocusModal" tabindex="-1" role="dialog" aria-labelledby="scanfocusModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scanfocusModal">Scanning Items Info</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                                 <div class="modal-body">
                                    <strong>Before scanning the items, make sure that the cursor was focus on the SKU/UPC input box.</strong>
                                    <img src='/img/scanfocus.PNG' alt="Info" width="100%" height="100%">
                                 </div>
                             <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                             </div>
                        </div>
                  </div>
             </div>
  <!-- Info scan focus modal end -->
                    <!-- Modal for Edit Remarks-->
                    <div class="modal fade" id="remarksModal" tabindex="-1" role="dialog" aria-labelledby="remarksModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="remarksModal">Add Remarks</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editRemarks()">
                        <div class="modal-body">
                           <div class="form-group">
                            <label>Remarks</label>
                            <select name="attrib1" v-model="form3.attrib1" id="attrib1" class="form-control" :class="{ 'is-invalid': form3.errors.has('attrib1') }">
                                <option value=" ">Select Remarks</option>
                                <option value="Damaged">Damaged</option>
                                <option value="Refunded">Refunded</option>
                                <option value="Change of Items">Change of Items</option>
                                <option value="Expired Goods">Expired Goods</option>
                                <option value="others">Others</option>
                            </select>
                            <has-error :form="form" field="attrib1"></has-error>
                        </div>
                         <div v-if="form3.attrib1 === 'others'" class="form-group">
                            <label>Other <b>Pls. Specify</b></label>
                            <input v-model="form4.attrib1" type="text" name="attrib1"
                            placeholder=" Other Remarks"
                            class="form-control" :class="{ 'is-invalid': form4.errors.has('attrib1') }">
                            <has-error :form="form" field="attrib1"></has-error>
                        </div>
                        <div v-else class="form-group">

                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Remarks</button>
                        </div>
                     </form>
                        </div>
                    </div>
                    </div>
                    <!-- edit remarks end -->
               <!-- Scan modal items tab-->
          <div class="modal fade" id="itemsTabinScan" name="itemsTabinScan" tabindex="-1" role="dialog" aria-labelledby="itemsTabinScanLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"  id="itemsTabinScanLabel">Add new items</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
            <!-- Items TAB-->
                  <div class="tab-pane" id="itemsScan">
                     <h1 align="center">Items</h1>
                         <div class="card-body">
                             <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button class="btn btn-primary"  @click="newModalinScan">Insert Manually <i class="fas fa-cart-plus"></i></button>
                                    </div>
                                </div>
                         <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"> Create Items</h3>
                                 <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" @keyup="searchitems" v-model="itemsearch" placeholder="Search">
                                    <div class="input-group-append">
                                    <button class="btn btn-navbar" @click="searchitems">
                                         <i class="fa fa-search"></i>
                                    </button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>SKU/UPC</th>
                                    <th>Description</th>
                                    <th> Price</th>
                                    <!-- <th> Location</th> -->
                                     <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in items.data" :key="item.id">
                                    <td align="center">{{item.sku_upc | upText}}</td>
                                    <td align="center">{{item.description | upText}}</td>
                                    <td align="center">${{item.price}}</td>
                                    <!-- <td>{{item.location | upText}}</td> -->
                                     <td align="center">
                                          <!-- <a href="#" @click="editModal(item)">
                                                <i class="fa fa-edit blue"></i>
                                            </a>
                                            | -->
                                           <a href="#"  @click="editModalinScan(item)">
                                            <i class="fa fa-clipboard blue"></i>
                                        </a>

                                     </td>
                                    </tr>
                                </tbody>
                                </table>
                                 <pagination :data="items" @pagination-change-page="getResults"></pagination>
                            </div>
                            <!-- /.card-body -->
                            </div>
                         <!-- /.card -->
                      </div>
                  </div>
         <!-- Modal for Insert Manually (ITEMS TAB in Scan) -->
                <div class="modal fade" id="addScan" name="addScan" tabindex="-1" role="dialog" aria-labelledby="addScanLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editscan" id="addScanLabel">Add new items</h5>
                            <h5 class="modal-title" v-show="editscan" id="addScanLabel">Add new items</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <form @submit.prevent="editscan ? addtoexistingItemsinScan() : createItemsinScan()">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label v-show="editscan">SKU/UPC</label>
                                        <input v-model="form.sku_upc" type="text" name="sku_upc"
                                            placeholder="SKU/UPC"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('sku_upc') }">
                                        <has-error :form="form" field="sku_upc"></has-error>
                                    </div>

                                <div class="form-group">
                                    <label v-show="editscan">Description</label>
                                    <input v-model="form.description" type="text" name="description"
                                        placeholder="Description"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                    <has-error :form="form" field="description"></has-error>
                                </div>

                                <div class="form-group">
                                    <label v-show="editscan">Price</label>
                                    <input v-model="form.price" type="text" name="price"
                                        placeholder="Price"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                                    <has-error :form="form" field="price"></has-error>
                                </div>
                                <!-- <div class="form-group">
                                    <label v-show="editscan">Location</label>
                                    <input v-model="form.location" type="text" name="location"
                                        placeholder="Location"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('location') }">
                                    <has-error :form="form" field="location"></has-error>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button v-show="editscan" type="submit" class="btn btn-success">Add</button>
                                <button v-show="!editscan" type="submit" class="btn btn-primary">Create</button>
                            </div>
                         </form>
                          </div>
                     </div>
                </div>
  <!-- end of modal for insert manually (ITEMS TAB in Scan)-->
             </div>
        </div>
    </div>
</div>
   <!-- Scan modal show items tab-->
</div>
  <!-- /.end scan -->
                    <!-- Items TAB-->
                  <div class="tab-pane" id="items">
                     <h1 align="center">Items</h1>
                         <div class="card-body">
                            <div class="col-sm-12">
                                <form class="form-horizontal" @submit.prevent="">
                                    <div class="form-group">
                                        <label for="file" class="col-sm-5 control-label">Upload CSV File</label>
                                        <div class="col-sm-8">
                                            <input type="file" id="csv_file" name="file" class="form-input" @change="loadCSV($event)"> <button class="btn btn-success" data-toggle="modal" data-target="#importItems"> <i class="fas fa-file-upload"></i> &nbsp; Import CSV</button>
                                        </div>
                                    </div>
                                </form>
                                    <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                            <a href="./WRAppTemplate.csv"><button class="btn btn-success"><i class="fas fa-file-download"></i> &nbsp; Download CSV Template</button></a>  <i class="fas fa-question-circle" data-toggle="modal" data-target="#infoModal"></i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                            <button class="btn btn-primary"  @click="newModal">Insert Manually <i class="fas fa-cart-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title"> Manage Items</h3>
                                                <div class="card-tools">
                                                    <div class="input-group input-group-sm" style="width: 150px;">
                                                    <input type="text" name="table_search" class="form-control float-right" @keyup="searchitems" v-model="itemsearch" placeholder="Search">
                                                    <div class="input-group-append">
                                                    <button class="btn btn-navbar" @click="searchitems">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                    <th>SKU/UPC</th>
                                                    <th>Description</th>
                                                    <th> Price</th>
                                                    <!-- <th> Location</th> -->
                                                    <th>Notes</th>
                                                    <th>Date Modified</th>
                                                    <th> Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="item in items.data" :key="item.id">
                                                    <td align="center">{{item.sku_upc | upText}}</td>
                                                    <td align="center">{{item.description | upText}}</td>
                                                    <td align="center">${{parseFloat(item.price).toFixed(2)}}</td>
                                                    <td>{{item.attrib1}}</td>
                                                    <td>{{item.updated_at}}</td>
                                                    <!-- <td>{{item.location | upText}}</td> -->
                                                    <td align="center">
                                                        <a href="#" @click="editModal(item)">
                                                                <i class="fa fa-edit blue"></i>
                                                            </a>
                                                            <!-- |
                                                        <a href="#" @click="deleteItem(item.id)">
                                                            <i class="fa fa-trash red"></i>
                                                        </a> -->

                                                    </td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                                <pagination :data="items" @pagination-change-page="getResults"></pagination>
                                            </div>
                                            <!-- /.card-body -->

                                            </div>

                                        <!-- /.card -->
                                    </div>
                                </div>
                        <!-- Modal for Import (ITEMS TAB)-->
                        <div class="modal fade" id="importItems" tabindex="-1" role="dialog" aria-labelledby="importItemsLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importItemsLabel">Import CSV File</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                         <form @submit.prevent="">
                                <div class="modal-body">
                                            <div class="card-body table-responsive p-0">
                                        <table v-if="parse_csv">
                                        <thead>
                                            <tr>
                                                <tr>
                                                <th v-for="item in parse_header" :key="item.id"
                                                    @click="sortBy(item)"
                                                    :class="{ active: sortKey == item }">
                                                    {{ item | upText }}
                                                    <span class="arrow" :class="sortOrders[item] > 0 ? 'asc' : 'dsc'">
                                                    </span>
                                                </th>
                                                </tr>
                                            </thead>
                                            <tr v-for="items in parse_csv" :key="items.id">
                                                <td v-for="item in parse_header" :key="item.id">
                                                {{items[item]}}
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                              </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button  type="submit" class="btn btn-primary"  @click="importCSV">Import</button>
                                </div>
                                </form>
                            </div>
                        </div>
                      </div>
      <!-- end of modal for import items (ITEMS TAB)-->
         <!-- Modal for Insert Manually (ITEMS TAB) -->
                <div class="modal fade" id="addNew" name="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add new items</h5>
                                <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Item Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <form @submit.prevent="editmode ? updateItems() : createItems()">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label v-show="editmode">SKU/UPC</label>
                                        <input v-model="form.sku_upc" type="text" name="sku_upc"
                                            placeholder="SKU/UPC"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('sku_upc') }">
                                        <has-error :form="form" field="sku_upc"></has-error>
                                    </div>
                                <div class="form-group">
                                    <label v-show="editmode">Description</label>
                                    <input v-model="form.description" type="text" name="description"
                                        placeholder="Description"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                    <has-error :form="form" field="description"></has-error>
                                </div>
                                <div class="form-group">
                                    <label v-show="editmode">Price</label>
                                    <input v-model="form.price" type="text" name="price"
                                        placeholder="Price"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                                    <has-error :form="form" field="price"></has-error>
                                </div>
                                <!-- <div class="form-group">
                                    <label v-show="editmode">Location</label>
                                    <input v-model="form.location" type="text" name="location"
                                        placeholder="Location"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('location') }">
                                    <has-error :form="form" field="location"></has-error>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                <button v-show="!editmode" type="submit" class="btn btn-primary">Add</button>
                            </div>
                         </form>
                    </div>
               </div>
           </div>
     <!-- end of modal for insert manually (ITEMS TAB)-->
         <!-- Info for Download CSV Modal -->
                    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="infoModal">Download CSV Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                                <div class="modal-body">
                                    <strong>CSV format for inserting bulk items.</strong>
                                    <img src='/img/infodlcsv.PNG' alt="Info" width="100%" height="100%">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                             </div>
                         </div>
                     </div>
         <!-- Info modal end -->
                </div>
        <!-- /.end items -->
       <!-- Reports TAB-->
                  <div class="tab-pane" id="reports">
                     <h1  v-show="!tabActive" align="center">Invoice</h1>
                    <div class="card-body">
                        <div class="col-12">
                            <button class="btn btn-primary"  v-show="!tabActive"  data-toggle="modal" data-target="#monthlyReports"><i class="fas fa-calendar-alt"></i> &nbsp; Monthly Invoice Reports</button>
                            <br> <br>
                            <div v-show="!tabActive" class="card">
                                <div class="card-header">
                                    <h3 v-show="!tabActive" class="card-title">Invoice Reports</h3>
                                        <div class="card-tools">
                                                <div class="card-tools">
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control float-right" @keyup="searchinvoices" v-model="reportsearch" placeholder="Search">
                                                <div class="input-group-append">
                                                <button class="btn btn-navbar" @click="searchinvoices">
                                                        <i class="fa fa-search"></i>
                                                </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                   <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <!-- <th>Invoice ID</th> -->
                                            <th>Invoice No</th>
                                            <th>Total Price</th>
                                            <th>Date</th>
                                            <th>Tendered By</th>
                                            <th> Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="invoice in invoices.data" :key="invoice.id">
                                            <!-- <td>{{invoice.id}}</td> -->
                                            <td align="center">{{invoice.invoice_no}}</td>
                                            <td align="center">${{ parseFloat(invoice.total).toFixed(2) }}</td>
                                            <td align="center">{{invoice.created_at | myDate}}</td>
                                            <td align="center">{{ invoice.attrib1 }}</td>
                                            <td align="center">
                                                 <!-- <a href="#" @click="updateQtyPrice(invoice_item)">
                                                        <i class="fas fa-edit green"></i>
                                                </a>
                                                | -->
                                                <a href="#" @click="getReports(invoice)">
                                                        <i class="fas fa-eye blue"></i>
                                                </a>
                                                |
                                                 <a href="#"  @click="delInvModal(invoice.id)">
                                                        <i class="fas fa-trash red"></i>
                                                </a>
                                            </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <pagination :data="invoices" @pagination-change-page="getInvoices"></pagination>
                                    </div>
                                </div>
                         <!-- /.card -->
                        </div>
                    </div>
               <!-- Modal for View Reports (REPORTS TAB)-->
                        <div class="modal fade" id="viewReports" tabindex="-1" role="dialog" aria-labelledby="viewReportsLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewReportsLabel">Invoice Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                       <form @submit.prevent="getReports()">
                            <div class="modal-body">
                                    <Label>Invoice No</Label>
                                    <div class="form-group">
                                        <input disabled v-model="form1.invoice_no" type="text" name="invoice_no"
                                            placeholder="Invoice No"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('invoice_no') }">
                                        <has-error :form="form" field="invoice_no"></has-error>
                                    </div>
                                    <Label>Total Price</Label>
                                    <div class="form-group">
                                        <input disabled v-model="form1.total" type="text" name="total"
                                            placeholder="Total Price"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('total') }">
                                        <has-error :form="form" field="total"></has-error>
                                    </div>
                                    <Label>Date</Label>
                                    <div class="form-group">
                                        <input disabled v-model="form1.created_at" type="text" name="created_at"
                                            placeholder="Date"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('created_at') }">
                                        <has-error :form="form" field="created_at"></has-error>
                                    </div>
                                </div>
                            </form>
                                <div class="card-body table-responsive p-0">
                                        <table id="invoices_items_id" class="table table-hover">
                                        <thead>
                                                <tr>
                                                <th>SKU/UPC</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total Price</th>
                                                <th>Remarks</th>
                                                <!-- <th>Location</th> -->
                                                </tr>
                                        </thead>
                                        <tbody>
                                                <!-- <tr v-for="invoice_item in invoice_items.data" :key="invoice_item.item_id"> -->
                                                <tr v-for="(invoice_item, index) in invoice_items.data" :key="'invoice_item' + index">
                                                <td align="center">{{invoice_item.sku_upc}}</td>
                                                <td align="center">{{invoice_item.description | upText}}</td>
                                                <td align="center">{{invoice_item.quantity}}
                                                 <i class="fas fa-plus green"  v-show="editOrAdd"  @click="invoiceItemAddQty(index)"></i>
                                                                                &nbsp;
                                                <i class="fas fa-minus orange" v-show="editOrAdd" @click="invoiceItemMinusQty(index)"></i></td>
                                                <td align="center">${{ parseFloat(invoice_item.price).toFixed(2) }}</td>
                                                <td align="center">${{ parseFloat(invoice_item.total_item_price).toFixed(2) }}</td>
                                                <td align="center">{{invoice_item.remarks}}</td>
                                                </tr>
                                        </tbody>
                                        </table>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success" @click="downloadCSV(items.data)"><i class="fas fa-file-csv"></i> &nbsp; Export to CSV</button>

                                            <button type="button" class="btn btn-primary" @click="generatePDF()"><i class="fas fa-file-pdf"></i> &nbsp; Generate PDF</button>
                                            <button type="button" v-show="!editOrAdd" class="btn btn-success"  @click="adminEditQty()"><i class="fas fa-edit"></i> &nbsp; Edit Invoice</button>
                                            <button type="button" v-show="editOrAdd" class="btn btn-primary" @click="saveEditInv()"><i class="fas fa-save"></i> &nbsp; Save Changes</button>

                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
            <!-- end of modal for view reports (REPORTS TAB) -->
         </div>
                  <!-- /.end reports -->
    <!-- Modal for invoice edit/soft delete -->
                    <div class="modal fade" id="invoiceActionsModal" tabindex="-1" role="dialog" aria-labelledby="invoiceActionsModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!delOrUpdate" id="invoiceActionsModal">Delete Invoice</h5>
                            <h5 class="modal-title" v-show="delOrUpdate" id="invoiceActionsModal">Update Invoice Remarks</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           <div v-show="!delOrUpdate" class="swal2-header"><ul class="swal2-progress-steps" style="display: none;"></ul><div class="swal2-icon swal2-error" style="display: none;"></div><div class="swal2-icon swal2-question" style="display: none;"></div><div class="swal2-icon swal2-warning swal2-icon-show" style="display: flex;"><div class="swal2-icon-content">!</div></div><div class="swal2-icon swal2-info" style="display: none;"></div><div class="swal2-icon swal2-success" style="display: none;"></div><img class="swal2-image" style="display: none;"><h2 class="swal2-title" id="swal2-title" style="display: flex;">Are you sure?</h2></div>
                           <div v-show="!delOrUpdate" class="swal2-content"><div id="swal2-content" class="swal2-html-container" style="display: block;">You won't be able to revert this!</div><input class="swal2-input" style="display: none;"><input type="file" class="swal2-file" style="display: none;"><div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select class="swal2-select" style="display: none;"></select><div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox" class="swal2-checkbox" style="display: none;"><input type="checkbox"><span class="swal2-label"></span></label><textarea class="swal2-textarea" style="display: none;"></textarea><div class="swal2-validation-message" id="swal2-validation-message"></div></div>

                          <form @submit.prevent="delOrUpdate ? null: deleteInvoice()">
                            <div class="modal-body1">
                                <div v-show="!delOrUpdate" class="form-group">
                                    <label v-show="!delOrUpdate">Remarks for Deletion</label>
                                    <input v-model="form5.attrib3" type="text" name="attrib3"
                                        placeholder="Remarks"
                                        class="form-control" :class="{ 'is-invalid': form5.errors.has('attrib3') }">
                                    <has-error :form="form" field="attrib3"></has-error>
                                </div>
                        </div>
                         <div v-show="delOrUpdate"  class="modal-body2">
                                <div class="form-group">
                                    <label v-show="delOrUpdate">Remarks for Editing Invoice</label>
                                    <input v-model="form6.attrib3" type="text" name="attrib3"
                                        placeholder="Remarks"
                                        class="form-control" :class="{ 'is-invalid': form6.errors.has('attrib3') }">
                                    <has-error :form="form" field="attrib3"></has-error>
                                </div>
                         </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" v-show="!delOrUpdate" class="btn btn-danger">Add Remarks for Deleting Invoice</button>
                            <button type="sumbit" v-show="delOrUpdate" class="btn btn-primary">Add Remarks for Editing Invoice</button>
                        </div>
                    </form>
                        </div>
                     </div>
                    </div>
                    </div>
                    <!-- Modal for invoice edit/soft delete end -->
           <!-- Modal  for monthly reports-->
                    <div class="modal fade" id="monthlyReports" tabindex="-1" role="dialog" aria-labelledby="monthlyReports" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="monthlyReports">Monthly Reports</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                             <div>
                                 <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr class="tablehead">
                                                    <th align="center">Start Date</th>
                                                    <th align="center">End Date</th>
                                                    </tr>
                                                    </thead>
                                                  <tbody>
                                                    <!-- <tr class="details" v-for="invoice_item in invoice_items.data" :key="invoice_item.item_id" > -->
                                                     <tr>
                                                         <td align="justify"><datetime format="YYYY-MM-DD"  v-model="start_date" width="100%"></datetime></td>
                                                         <td align="justify"><datetime format="YYYY-MM-DD" v-model="end_date"  width="100%"></datetime></td>
                                                        <td align="justify"><button class="btn btn-navbar" @click="searchForInvoicesReport">
                                                        <i class="fa fa-search"></i>
                                                    </button></td>
                                                      </tr>
                                                      <br> <br> <br> <br>  <br> <br>  <br> <br>  <br> <br>  <br> <br>
                                                      </tbody>
                                                  </table>
                                                </div>
                                            <!-- /.col -->
                                        </div>
                                         <!-- Table row -->
                                       <div class="row">
                                            <div class="col-12 table-responsive">
                                                  <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <!-- <th>Invoice ID</th> -->
                                            <th>Invoice No</th>
                                            <th>Total Price</th>
                                            <th>Date</th>
                                            <th>Tendered By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(invoice,index) in invoice_for_export" :key="'invoice'+index">
                                                <td align="center">{{invoice.invoice_no}}</td>
                                                <td align="center">${{ parseFloat(invoice.total).toFixed(2) }}</td>
                                                <td align="center">{{invoice.created_at | myDate}}</td>
                                                <td align="center">{{ invoice.attrib1 }}</td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                            <!-- /.col -->
                                        </div>
                                       <!-- /.row -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" @click="pdfMonthly()" ><i class="fas fa-file-pdf"></i> &nbsp; Export to PDF</button>
                        </div>
                        </div>
                    </div>
                    </div>
       <!-- Modal  for monthly reports-->
         <!-- Export Report to PDF TAB-->
                  <div class="tab-pane" id="monthly">
                       <div v-show="monthActive"  class=" no-print col-sm-offset-2 col-sm-12">
                               <button type="button" class="btn btn-primary" @click="backInvoice()"><i class="fas fa-arrow-alt-circle-left"></i> &nbsp; Back</button>
                         </div>
                      <div class="header no-print">
                               <h1  v-show="monthActive" align="center">Monthly Invoice Reports</h1>
                      </div>
                    <div v-show="monthActive" class="card-body">
                         <br>
                        <div class="col-12">
                             <div class="card-tools">
                                     <div class="invoice p-3 mb-3">
                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-12">
                                        <h4>
                                            <i class="fas fa-receipt"></i> Warehouse Receiving
                                            <small class="float-right"><b>Start Date:{{this.start_date | myDate}}</b></small>
                                        </h4>
                                        </div>
                                         <div class="col-12">
                                        <h4>
                                           <small class="float-right"><b>End Date:{{this.end_date | myDate}}</b></small>
                                        </h4>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </div>
                                    <!-- /.row -->
                                    <!-- Table row -->
                                       <div class="row">
                                            <div class="col-12 table-responsive">
                                                  <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                            <!-- <th>Invoice ID</th> -->
                                                            <th>Invoice No</th>
                                                            <th>Total Price</th>
                                                            <th>Date</th>
                                                            <th>Tendered By</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                             <!-- <tr v-for="invoice_item in invoice_items.data" :key="invoice_item.id">
                                                                <td align="center">{{invoice_item.invoice_no}}</td>
                                                                <td align="center">${{ parseFloat(invoice_item.total).toFixed(2) }}</td>
                                                                <td align="center">{{invoice_item.created_at | myDate}}</td>
                                                                <td align="center">{{ invoice_item.attrib1 }}</td>
                                                            </tr> -->
                                                            
                                                            <tr v-for="(invoice,index) in invoice_for_export" :key="'invoice'+index">
                                                                <td align="center">{{invoice.invoice_no}}</td>
                                                                <td align="center">${{ parseFloat(invoice.total).toFixed(2) }}</td>
                                                                <td align="center">{{invoice.created_at | myDate}}</td>
                                                                <td align="center">{{ invoice.attrib1 }}</td>
                                                            </tr>
                                                        </tbody>
                                                        </table>
                                                </div>
                                            <!-- /.col -->
                                        </div>
                                       <!-- /.row -->
                              <!-- this row will not appear when printing -->
                                 <div class="card-body no-print">
                                     <div class="col-sm-12">
                                    <button type="button" @click="printme()" class="btn btn-primary float-right" style="margin-right: 5px;">
                                        <i class="fas fa-download"></i> Download PDF
                                    </button>
                                 <br>
                                   </div>
                             </div>
                           </div>
                      </div>
  <!-- /.card -->
                    </div>
                  </div>
                   <!-- /.end tab for monthly -->
           <!-- Print TAB-->
                  <div class="tab-pane" id="print">
                       <div v-show="tabActive"  class=" no-print col-sm-offset-2 col-sm-12">
                               <button type="button" class="btn btn-primary" @click="showInvoice()"><i class="fas fa-arrow-alt-circle-left"></i> &nbsp; Back</button>
                         </div>
                      <div class="header no-print">
                               <h1   v-show="tabActive" align="center">Print Invoice</h1>
                      </div>
                    <div v-show="tabActive"  class="card-body">
                         <br>
                        <div class="col-12">
                             <div class="card-tools">
                                     <div class="invoice p-3 mb-3">
                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-12">
                                        <h4>
                                            <i class="fas fa-receipt"></i> Warehouse Receiving
                                            <small class="float-right">Date:{{this.form1.created_at | myDate}}</small>
                                        </h4>
                                        </div>
                                         <div class="col-12">
                                        <h4>
                                            <strong class="float-right">Invoice #: {{this.form1.invoice_no}} </strong>
                                        </h4>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </div>
                                    <!-- /.row -->
                                    <!-- Table row -->
                                       <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr class="tablehead">
                                                    <th>SKU/UPC</th>
                                                    <th>Description</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Amount</th>
                                                    </tr>
                                                    </thead>
                                                  <tbody>
                                                    <!-- <tr class="details" v-for="invoice_item in invoice_items.data" :key="invoice_item.item_id" > -->
                                                     <tr v-for="(invoice_item, index) in invoice_items.data" :key="'invoice_item' + index">
                                                       <td align="justify">{{invoice_item.sku_upc}}</td>
                                                        <td align="justify">{{invoice_item.description | upText}}</td>
                                                        <td align="justify">{{invoice_item.quantity}}</td>
                                                         <td align="justify">${{ parseFloat(invoice_item.price).toFixed(2) }}</td>
                                                         <td align="justify">${{ parseFloat(invoice_item.total_item_price).toFixed(2) }}</td>
                                                      </tr>
                                                    <tr>
                                                     <td align="justify"></td>
                                                        <td align="justify"></td>
                                                        <td align="justify"></td>
                                                        <td align="justify"><b>Total:</b></td>
                                                        <td align="justify"><b>${{parseFloat(this.form1.total).toFixed(2)}}</b></td>
                                                        </tr>
                                                      </tbody>
                                                  </table>
                                                </div>
                                            <!-- /.col -->
                                        </div>
                                       <!-- /.row -->
                              <!-- this row will not appear when printing -->
                                 <div class="card-body no-print">
                                     <div class="col-sm-12">
                                    <button type="button" @click="printme()" class="btn btn-primary float-right" style="margin-right: 5px;">
                                        <i class="fas fa-download"></i> Download PDF
                                    </button>
                                 <br>
                                   </div>
                             </div>
                           </div>
                      </div>
  <!-- /.card -->
                    </div>
                  </div>
                   <!-- /.end tab for print -->
              </div>
    <!-- /.end tab  -->
            </div>
        </div>
    </div>
<!-- /.tab-content -->
</div>
</template>
<script>
    import Swal from 'sweetalert2';
    import jsPDF from 'jspdf';
    import html2canvas from 'html2canvas';
    import Datepicker from 'vuejs-datepicker';
    export default {
        data(){
            return {
                isHidden: true,
                //import
                channel_name: '',
                channel_fields: [],
                channel_entrier: [],
                parse_header: [],
                parse_csv: [],
                sortOrders: {},
                sortKey: '',
                itemsearch: '', //items
                reportsearch: '', //reports
                sku_input: null,
                qty_input: '1',
                get_sku: null,
                editmode: false, //For update and create form in items
                editscan: false, // for copy and create in scans
                tabActive: false, // for showing and hiding print invoices
                monthActive: false,
                delOrUpdate: false, //delete or update invoice
                editOrAdd: false,//edit and save invoice
                focusChecker: false,
                items: {},
                invoices: {},
                invoice_items: {},
                form: new Form({
                    //items
                    id: '',
                    sku_upc: '',
                    description: '',
                    price: '',
                    location:'',
                    created_at: '',
                     item_id:'',
                }),
                form1: new Form({
                   //invoices
                    id: '',
                    invoice_no: '',
                    total: '',
                    created_at: '',
                    item_id:'',
                }),
                  form2: new Form({
                   //import items
                     id: '',
                    sku_upc: '',
                    description: '',
                    price: '',
                    location:'',
                }),
                 form3: new Form({ //select
                   //remarks for scan select
                     id: '',
                    attrib1:'',
                }),
                 form4: new Form({ //input
                   //remarks for scan input
                     id: '',
                    attrib1:'',
                }),
                form5: new Form({ //input
                   //remarks for invoice delete
                     id: '',
                    attrib1:'',
                    attrib2: '',
                    attrib3: '',
                }),
                 form6: new Form({ //input
                   //remarks for invoice edit
                     id: '',
                    attrib1:'',
                    attrib2: '',
                    attrib3: '',
                }),
                scanned_single_item: null,
                scanned_items: [],
                loading: false,
                status: null,
                errors: null,
                total_price: 0,
                invoice_id_for_deletion: null,
                start_date: null,
                end_date: null,
                invoice_for_export:{},
            }
        },
            computed: {
            hasErrors() {
            return 400 === this.status && this.errors !== null;
            },
            hasAvailability() {
            return 200 === this.status;
            }
        },
        methods: {
            showAlertonFocus(){
                this.focusChecker= true;
                if (!this.$refs.scanner.focus()){
                    alert('Not Focus');
                }
            },
            defaultFocus(){
                this.focusChecker= false;
                 if (this.$refs.scanner.focus()){
                    alert('Focus');
                }
            },
             //SCAN METHODS START
            loadScans(){
                 axios.get(this.scanned_item_edit_selected_id);
            },
            getSelectedItemIdForRemarks(index){
                // console.log(index);
                 $('#remarksModal').modal('show');
                this.scanned_item_edit_selected_id = index;
            },
            scannedItemAddQty(index){
                this.scanned_items[index].qty = parseInt(this.scanned_items[index].qty) + 1;
                this.computeTotalScannedItems();
            },
            scannedItemMinusQty(index){
                this.scanned_items[index].qty = parseInt(this.scanned_items[index].qty) - 1;
                this.computeTotalScannedItems();
            },
            editRemarks(){
                console.log(this.form3.attrib1);
                this.$Progress.start();
                // axios.post('/api/invoice', this.scanned_items)
                if(this.form3.attrib1 != 'others'){
                    console.log('execute');
                    console.log(this.scanned_item_edit_selected_id);
                    console.log(this.scanned_items[this.scanned_item_edit_selected_id]);
                    this.scanned_items[this.scanned_item_edit_selected_id].remarks =  this.form3.attrib1;
                    // this.scanned_items[this.scanned_item_edit_selected_id].remarks = this.form4.attrib1;
                                //    setInterval(() => this.loadScans(), 3000);
                }
                else{
                    this.scanned_items[this.scanned_item_edit_selected_id].remarks = this.form4.attrib1;
                }
                $('#remarksModal').modal('hide');
                                Swal.fire(
                                    'Added!',
                                    'Remarks has been added.',
                                    'success'
                                )
                             this.$Progress.finish();
                                Fire.$emit('AfterCreate');
             },
             searchitemsinscan: _.debounce(() => { //search items in scan tab
                 Fire.$emit('searching in items');
            }, 1000),
            checkout(){ // generating invoice for all scanned items
                // this.loading = true;
                if (!this.scanned_items.length || this.scanned_items[0].qty == '0'){
                    //FIXME: add sweetalert for no items
                    alert('No items found');
                }
                else{
                    // alert('we have items');
                    axios.post('/api/invoice', this.scanned_items)
                        .then(response => {
                              Swal.fire({
                                title: 'Confirm Checkout?',
                                text: "You won't be able to revert this!",
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, proceed to checkout'
                                }).then((result) => {
                                if (result.value) {
                                    Swal.fire(
                                    response.data['invoice_no']+' Checkout Successfully!',
                                    'View invoice tab for more information.',
                                    'success'
                                    )
                                    this.scanned_items = [];
                                    this.isHidden = true;
                                }
                        })
                        Fire.$emit('AfterCreate');
                        this.$Progress.finish();
                        })
                        .catch(error => {
                        })
                        .then(() => {
                            this.loading = false;
                        });
                }
            },
             editModalinScan(item){ // Form for autofill insert in scan tab
                this.editscan = true;
                this.form.reset();
                $('#addScan').modal('show');
                this.form.fill(item);
                this.form.sku_upc = '';
            },
            newModalinScan(){ //Form for insert manually in scan tab
                this.editscan = false;
                this.form.reset();
                $('#addScan').modal('show');
            },
            addtoexistingItemsinScan(){ //autofill insert in scan tab
                this.$Progress.start();
                this.form.post('api/item')
                .then(() => {
                    $('#addScan').modal('hide');
                        Swal.fire(
                            'Added!',
                            'Item added successfully.',
                            'success'
                        )
                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            createItemsinScan(){ //insert manually in scan tab
                this.$Progress.start();
                this.form.post('api/item')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addScan').modal('hide')
                    this.form.reset();
                    Toast.fire({
                        icon: 'success',
                        title: 'Item added successfully'
                        })
                this.$Progress.finish()
                })
                .catch(()=>{
                    this.$Progress.fail();
                })
            },
            computeTotalScannedItems(){
                this.total_price = 0;
                for(let i=0;i < this.scanned_items.length; i++){
                    // console.log('total price'+ this.total_price);
                    // console.log(this.scanned_items[i].qty);
                    // console.log('dumaan ka dito');
                    // if(this.scanned_items[i].sku_upc == response.data.data['sku_upc'] ){
                        // this.item_already_exists=true;
                        // this.scanned_items[i].qty = parseInt(this.scanned_items[i].qty) + parseInt(this.qty_input);
                    // }
                    this.total_price = parseFloat(this.total_price) + (parseFloat(this.scanned_items[i].qty) * parseFloat(this.scanned_items[i].price));
                    }
            },
            scanItems(){ //for scanning items ,scan tab
                // this.sku_loading = true;
                this.errors = null;
                this.get_sku = this.sku_input;
                if(this.sku_input != null){
                axios
                .get(`/api/itemavailability/${this.sku_input}`)
                .then(response => {
                this.status = response.status;
                this.isHidden=false;
                this.total_price = 0;
                for(let i=0;i < this.scanned_items.length; i++){
                    // console.log('total price'+ this.total_price);
                    // console.log(this.scanned_items[i].qty);
                    // console.log('dumaan ka dito');
                    if(this.scanned_items[i].sku_upc == response.data.data['sku_upc'] ){
                        this.item_already_exists=true;
                        this.scanned_items[i].qty = parseInt(this.scanned_items[i].qty) + parseInt(this.qty_input);
                    }
                    this.total_price = parseFloat(this.total_price) + (parseFloat(this.scanned_items[i].qty) * parseFloat(this.scanned_items[i].price));
                    }
                if(!this.item_already_exists){
                    this.total_price = 0;
                    this.scanned_items.unshift({'id': response.data.data['id'],'sku_upc': response.data.data['sku_upc'],'description': response.data.data['description'],'qty': this.qty_input, 'price': response.data.data['price'], 'remarks':' '});
                    for(let i=0;i < this.scanned_items.length; i++){
                        this.total_price = parseFloat(this.total_price) + (parseFloat(this.scanned_items[i].qty) * parseFloat(this.scanned_items[i].price));
                        }
                    }})
                .catch(error => {
                if (400 === error.response.status) {
                    this.errors = error.response.data.errors;
                    Swal.fire({
                    title: 'No item found!',
                    text: "Item does not exist",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4CAF50',
                    confirmButtonText: 'Scan Again',
                    cancelButtonColor: '#0065ff',
                    cancelButtonText: 'Insert manually',
                    }).then( function (isConfirm){
                        console.log(isConfirm);
                        if(isConfirm.dismiss == 'cancel'){
                          $('#itemsTabinScan').modal('show');
                        }
                    });
                }
                this.status = error.response.status;
                })
                .then(() => {
                    this.qty_input = '1';
                    this.sku_input = null;
                    this.item_already_exists=false;
                });
                }
            },
            removeRow(index){
            this.scanned_items.splice(index, 1);
            if(!this.scanned_items.length){
                this.isHidden=true;
            }
            },
            //  SCAN METHODS END
            //REPORTS METHODS START
            searchForInvoicesReport(){
                 axios.get(`api/searchForInvoicesExport/?start_date=${this.start_date}&end_date=${this.end_date}`).then(({data}) => (this.invoice_for_export= data));
                //  axios.get('api/invoice?page=' + page)
                //             .then(response => {
                //                 this.invoices = response.data;
                //             });
                // Fire.$on('searching',() => {
                // let query = this.itemsearch;
                // axios.get('api/findItem?q=' + query)
                // .then((data) => {
                //     this.items = data.data
                // })
                // .catch(() => {
                // })
            // })
            },
             backInvoice(){// after generating pdf , for button show invoices
            //   location.reload();
                this.tabActive = false;
                this.monthActive = false;
                 $('#reports').tab('show');
                 $('#monthly').tab('hide');
                 $('#print').tab('hide');
            },
            pdfMonthly(){ // for showing print invoice, hide invoice tab
                 this.monthActive = true;
                 this.tabActive = true;
                $('#monthlyReports').modal('hide');
                $('#monthly').tab('show');
                $('#reports').tab('hide');
                $('#print').tab('hide');
            },
             editQtyRemarks(){
                //save changes and add remarks
                this.$Progress.start();
                console.log()
                axios.post(`api/updateInvoice/?invoice_id=${this.invoice_id_for_update_deletion}&remarks=${this.form6.attrib3}`,this.invoice_items.data)
                .then(() => {
                    $('#invoiceActionsModal').modal('hide');
                        Swal.fire(
                            'Updated!',
                            'Invoice has been updated.',
                            'success'
                        )
                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                }).then(()=>{
                    this.form6,attrib3 = null;
                });
            },
            saveEditInv(){
                //showing remarks modal for editting
                this.editOrAdd = false;
                this.delOrUpdate = true;
                this.form.reset();
                $('#invoiceActionsModal').modal('show');
            },
            adminEditQty(){
                 this.editOrAdd = true;
            },
            invoicecomputeTotal(index){
                console.log(this.invoices.data[index].total);
                this.form1.total = 0;
                console.log(this.invoice_items.data.length);
                for(let i=0;i< this.invoice_items.data.length;i++){
                    this.invoice_items.data[i].total_item_price= 0;
                    // this.invoice_items.data[i].total_item_price= parseFloat(this.invoice_items.data[i].total_item_price) + (parseFloat(this.invoice_items.data[i].quantity) * parseFloat(this.invoice_items.data[i].price));
                    this.invoice_items.data[i].total_item_price = parseFloat(this.invoice_items.data[i].price) * this.invoice_items.data[i].quantity;
                    this.form1.total  +=  parseFloat(this.invoice_items.data[i].total_item_price);
                }
            },
             invoiceItemAddQty(index){
                this.invoice_items.data[index].quantity = parseInt(this.invoice_items.data[index].quantity) + 1;
                this.invoicecomputeTotal(index);
            },
            invoiceItemMinusQty(index){
                this.invoice_items.data[index].quantity = parseInt(this.invoice_items.data[index].quantity) - 1;
                this.invoicecomputeTotal(index);
            },
            delInvModal(index){ //Form for deleting invoice and adding reason
                this.invoice_id_for_deletion = index;
                this.delOrUpdate = false;
                this.form.reset();
                $('#invoiceActionsModal').modal('show');
            },
             deleteInvoice(){
                this.$Progress.start();
                this.form.post(`api/softDelete/?invoice_id=${this.invoice_id_for_deletion}&remarks=${this.form5.attrib3}`)
                .then(() => {
                    $('#invoiceActionsModal').modal('hide');
                        Swal.fire(
                            'Deleted!',
                            'Invoice has been Deleted.',
                            'success'
                        )
                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
             showInvoice(){// after generating pdf , for button show invoices
                location.reload();
                this.tabActive = false;
                this.monthActive = false;
                 $('#reports').tab('show');
                 $('#print').tab('hide');
                 $('#monthly').tab('hide');
            },
            hideInvoice(){// hide invoice when generating pdf
                this.tabActive = false;
                 $('#reports').tab('hide');
            },
             printme() { // for printing PDF invoice
                 document.title=this.form1.invoice_no ;
                 window.print();
                },
             generatePDF(){ // for showing print invoice, hide invoice tab
               // $('#monthly').tab('hide');
                 this.tabActive = true;
                 this.monthActive = false;
                $('#viewReports').modal('hide');
                $('#print').tab('show');
                $('#monthly').tab('hide');
            },
            downloadCSV(invoice_items){//, invoice_date, invoice_total_price, invoice_items //download pdf file in reports tab
                let csvContent = "data:text/csv;charset=utf-8,";
                csvContent += 'Date:,'+ this.form1.created_at +'\n';
                csvContent += 'Invoice No:,'+ this.form1.invoice_no +'\n\N';
                csvContent += 'SKU_UPC,Description,Price,Quantity,Total Price\n';
                for(let i = 0; i < this.invoice_items.data.length; i++){
                    csvContent += this.invoice_items.data[i].sku_upc +','+ this.invoice_items.data[i].description + ',' + this.invoice_items.data[i].price + ',' + this.invoice_items.data[i].quantity +','+ this.invoice_items.data[i].total_item_price +',\n';
                }
                csvContent += ',,,Total:,'+this.form1.total+',\n';
                var encodedUri = encodeURI(csvContent);
                var link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", this.form1.invoice_no+'.csv' );
                document.body.appendChild(link); // Required for FF
                link.click();
            },
            getReports(invoice, invoice_items){ //View action in reports tab
                // this.form.reset();
                $('#viewReports').modal('show');
                   this.form1.fill(invoice);
                axios.get('api/invoice/'+this.form1.id).then(({data}) => (this.invoice_items= data));
            },
            getInvoices(page = 1) { //Pagination for invoices in reports tab
                        axios.get('api/invoice?page=' + page)
                            .then(response => {
                                this.invoices = response.data;
                            });
           },
            loadInvoices(){ //load invoices in reports tab
                axios.get("api/invoice").then(({data}) => (this.invoices = data));
            },
            searchinvoices: _.debounce(() => { //search invoices in reports tab
                Fire.$emit('searching');
            }, 1000),
             //REPORTS METHODS END
            // ITEM METHODS START
           importCSV(){ //import csv into database
                    var vm = this;
                this.$Progress.start();
                axios.post('api/importCSV',vm.parse_csv)
                // console.log(this.parse_csv)
                 //axios.post("api/importCSV").then(({data}) => (this.items = data))
                .then(()=>{
                    Fire.$emit('AfterCreate');
                     $('#importItems').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: 'Items added successfully'
                        })
                this.$Progress.finish()
                })
                .catch(()=>{
                    this.$Progress.fail()
                     Swal.fire("Failed!", "Check for duplicate or invalid entries, then import again", "warning");
                })
            },
            sortBy: function (item){ // sort csv
                var vm = this
                vm.sortKey = item
                vm.sortOrders[item] = vm.sortOrders[item] * -1
            },
            csvJSON(items){ //insert csv
            console.log(items);
            var vm = this
            var lines = items.split("\n")
            var result = []
            var headers = lines[0].split(",")
            vm.parse_header = lines[0].split(",")
            lines[0].split(",").forEach(function (item) {
                vm.sortOrders[item] = 1
            })
            lines.map(function(line, indexLine){
                if (indexLine < 1) return // Jump header line
                var obj = {}
                var currentline = line.split(",")
                headers.map(function(header, indexHeader){
                obj[header] = currentline[indexHeader]
                })
                result.push(obj)
            })
            result.pop() // remove the last item because undefined values
            return result // JavaScript object
            },
            loadCSV(e){ // load csv before importing
                var vm = this
                if(window.FileReader){
                    var reader = new FileReader();
                    reader.readAsText(e.target.files[0]);
                    reader.onload = function(event){
                        var items = event.target.result;
                        vm.parse_csv = vm.csvJSON(items)
                    };
                reader.onerror = function(evt){
                    if(evt.target.error.name == "NotReadableError"){
                        alert("Cannot read file!");
                    }
                };
                }else{
                    alert('FileReader are not supported in this browser');
                }
            },
            searchitems: _.debounce(() => { //search items in items tab
                 Fire.$emit('searching');
            }, 1000),
            getResults(page = 1) { //Pagination for items tab
                        axios.get('api/item?page=' + page)
                            .then(response => {
                                this.items = response.data;
                            });
                },
            updateItems(){ //Updating items for items tab
                this.$Progress.start();
                this.form.put('api/item/'+this.form.id)
                .then(() => {
                    $('#addNew').modal('hide');
                        Swal.fire(
                            'Updated!',
                            'Item has been updated.',
                            'success'
                        )
                        this.$Progress.finish();
                        Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            editModal(item){ //Form for updating items
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(item);
            },
            newModal(){ //Form for creating items
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            loadItems(){ // Load created items in items tab
                 axios.get("api/item").then(({ data }) => (this.items = data));
            },
            createItems(){ // Creating new items in items tab
                this.$Progress.start();
                this.form.post('api/item')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: 'Item added successfully'
                        })
                this.$Progress.finish()
                })
                .catch(()=>{
                      this.$Progress.fail();
                })
            }
              // ITEM METHODS END
        },
        mounted() {
            this.$refs.scanner.focus();
        },
        created() {
            //items search
             Fire.$on('searching',() => {
                let query = this.itemsearch;
                axios.get('api/findItem?q=' + query)
                .then((data) => {
                    this.items = data.data
                })
                .catch(() => {
                })
            })
            this.loadItems();
            Fire.$on('AfterCreate',() => {
                this.loadItems();
            this.$refs.scanner.$el.focus();
           });
           //reports search
           Fire.$on('searching', () => {
               let query = this.reportsearch;
               axios.get('api/findInvoiceHistory?q=' + query)
               .then((data) => {
                   this.invoices = data.data
               })
               .catch(() =>{
               })
           })
            this.loadInvoices();
               Fire.$on('AfterCreate', () =>{
                   this.loadInvoices();
               });
               //scans
               Fire.$on('AfterCreate', () =>{
                   this.loadScans();
               });
        },
    }
</script>
<style>
    html {
        margin: 0px;
        padding: 0;
    }
    .panel {
        border: 2px solid #dfdfdf;
        box-shadow: rgba(0, 0, 0, 0.15) 0 1px 0 0;
        margin: 10px;
    }
    .panel.panel-sm {
        max-width: 700px;
        margin: 10px auto;
    }
    .panel-heading {
        border-bottom: 2px solid #dfdfdf;
    }
    .panel-heading h1, .panel-heading h2, .panel-heading h3, .panel-heading h4, .panel-heading h5, .panel-heading h6 {
        margin: 0;
        padding: 0;
    }
    .panel-body .checkbox-inline {
         padding: 15px 20px;
    }
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    th {
    text-align: center;
    border: 1px solid #dddddd;
    padding: 2px;
    }
    td {
    border: 1px solid #dddddd;
    padding: 2px;
    }
    tr:nth-child(even) {
    background-color: #dddddd;
    }
    .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }
    /* for Print */
    @media print {
    @page { margin: 0; }
    body { margin: 1.6cm; }
    }
    .alert {
    padding: 10px;
    background-color:#4CAF50;
    color: white;
    }
</style>