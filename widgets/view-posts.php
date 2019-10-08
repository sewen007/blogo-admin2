5<!--begin: Datatable -->
<div class="m_datatable m-datatable m-datatable--default m-datatable--brand m-datatable--loaded" id="auto_column_hide" style="">
    <table class="m-datatable__table" style="display: block; min-height: 300px; overflow-x: auto;">
        <thead class="m-datatable__head">
            <tr class="m-datatable__row" style="left: 0px;">
                <th class="m-datatable__cell m-datatable__toggle-detail m-datatable__cell--sort"><span style="width: 21px;"></span></th>
                <th data-field="OrderID" class="m-datatable__cell m-datatable__cell--sort"><span style="width: 110px;">Date</span></th>
                <th data-field="ShipCountry" class="m-datatable__cell m-datatable__cell--sort"><span style="width: 150px;">Title</span></th>
                <th data-field="ShipCity" class="m-datatable__cell m-datatable__cell--sort"><span style="width: 110px;">Creator</span></th>
                <th data-field="Latitude" class="m-datatable__cell m-datatable__cell--sort"><span style="width: 110px;">Image_Url</span></th>
                <th data-field="Longitude" class="m-datatable__cell m-datatable__cell--sort""><span style="width: 110px;">Tags</span></th>
                <th data-field="Longitude" class="m-datatable__cell m-datatable__cell--sort""><span style="width: 110px;">View Post</span></th>
            </tr>
        </thead>
        <tbody class="m-datatable__body" style="">
            <?php
            $count = 1;
            foreach ($allPosts as $post) {
                $allBlogPosts = $blog->getAllBlogPosts($post['blog_id']);
                $position = $count % 2;
                $date = new DateTime($post['timestamp']);
                $timestamp = $date->format('jS M Y');
                if ($position == 1){
            ?>
            <tr data-row="0" class="m-datatable__row" style="left: 0px;">
                <td class="m-datatable__cell m-datatable__toggle--detail">
                    <a class="m-datatable__toggle-detail" style="cursor: pointer; color: #5867dd">
                        <i class="fa fa-caret-right" style="width: 21px;"></i>
                    </a>
                </td>
                <td data-field="OrderID" class="m-datatable__cell"><span style="width: 110px;"><?php echo $timestamp; ?></span></td>
                <td data-field="ShipCountry" class="m-datatable__cell"><span style="width: 150px;"><?php echo $post['title']; ?></span></td>
                <td data-field="ShipCity" class="m-datatable__cell"><span style="width: 110px;"><?php echo $post['creator']; ?></span></td>
                <td data-field="Latitude" class="m-datatable__cell"><span style="width: 110px;"><?php echo $post['image_url']; ?></span></td>
                <td data-field="Longitude" class="m-datatable__cell"><span style="width: 110px;"><?php echo $post['tags']; ?></span></td>
                <td data-field="Longitude" class="m-datatable__cell"><span style="width: 110px;"><a target="_blank" href= >View Post</a></span></td>

            </tr>
            <tr class="m-datatable__row-detail" style="display: none">
                <td class="m-datatable__detail" colspan="14">
                    <table>
                        
                        <tr class="m-datatable__row">
                            <td class="m-datatable__cell"><span style="width: 110px;">Edit</span></td>
                            <td data-field="TotalPayment" class="m-datatable__cell" style=""><a href="edit-payment?payment-id=<?php echo $post['blog_id']; ?>" >Edit Entry</a></td>
                        </tr>
                        <tr class="m-datatable__row">
                            <td class="m-datatable__cell"><span style="width: 110px;">Delete</span></td>
                            <td data-field="Status" class="m-datatable__cell" style="">
                                <a class="delete-payment-button" href="" data-toggle="modal" data-target="#m_modal_1">Delete Entry</a>
                                <p style="display: none"><?php echo $post['blog_id']; ?></p>
                            </td>
                        </tr>
<!--                        <tr class="m-datatable__row">
                            <td class="m-datatable__cell"><span style="width: 110px;">Type</span></td>
                            <td data-field="Type" class="m-datatable__cell" style=""><span style="width: 110px;"><span class="m-badge m-badge--danger m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-danger">Online</span></span>
                            </td>
                        </tr>-->
                    </table>
                </td>
            </tr>
            <?php
                } else {
            ?>
            <tr data-row="1" class="m-datatable__row m-datatable__row--even" style="left: 0px;">
                <td class="m-datatable__cell m-datatable__toggle--detail">
                    <a class="m-datatable__toggle-detail" style="cursor: pointer; color: #5867dd">
                        <i class="fa fa-caret-right" style="width: 21px;"></i>
                    </a>
                </td>
                <td data-field="OrderID" class="m-datatable__cell"><span style="width: 110px;"><?php echo $timestamp; ?></span></td>
                    <td data-field="ShipCountry" class="m-datatable__cell"><span style="width: 150px;"><?php echo $post['title']; ?></span></td>
                    <td data-field="ShipCity" class="m-datatable__cell"><span style="width: 110px;"><?php echo $post['creator']; ?></span></td>
                    <td data-field="Latitude" class="m-datatable__cell"><span style="width: 110px;"><?php echo $post['image_url']; ?> products</span></td>
                    <td data-field="Longitude" class="m-datatable__cell"><span style="width: 110px;"><?php echo $post['tags']; ?></span></td>
                    <td data-field="Longitude" class="m-datatable__cell"><span style="width: 110px;"><a target="_blank" href="<?php echo $post['content']; ?>">View Post</a></span></td>
            </tr>
            <tr class="m-datatable__row-detail" style="display: none">
                <td class="m-datatable__detail" colspan="14">
                    <table>
                        
                        
                        <tr class="m-datatable__row">
                            <td class="m-datatable__cell"><span style="width: 110px;">Edit</span></td>
                            <td data-field="TotalPayment" class="m-datatable__cell" style=""><a href="edit-payment?payment-id=<?php echo $post['blog_id']; ?>">Edit Entry</a></td>
                        </tr>
                        <tr class="m-datatable__row">
                            <td class="m-datatable__cell"><span style="width: 110px;">Delete</span></td>
                            <td data-field="Status" class="m-datatable__cell" style="">
                                <a class="delete-payment-button" href="" data-toggle="modal" data-target="#m_modal_1">Delete Entry</a>
                                <p style="display: none"><?php echo $post['blog_id']; ?></p>
                            </td>
                        </tr>
<!--                        <tr class="m-datatable__row">
                            <td class="m-datatable__cell"><span style="width: 110px;">Type</span></td>
                            <td data-field="Type" class="m-datatable__cell" style=""><span style="width: 110px;"><span class="m-badge m-badge--danger m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-danger">Online</span></span>
                            </td>
                        </tr>-->
                    </table>
                </td>
            </tr>
            <?php
                }
                $count++;
            }
            ?>
            
            
        </tbody>
    </table>
    <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
        <ul class="m-datatable__pager-nav">
            <li><a title="First" class="m-datatable__pager-link m-datatable__pager-link--first m-datatable__pager-link--disabled" data-page="1" disabled="disabled"><i class="la la-angle-double-left"></i></a></li>
            <li><a title="Previous" class="m-datatable__pager-link m-datatable__pager-link--prev m-datatable__pager-link--disabled" data-page="1" disabled="disabled"><i class="la la-angle-left"></i></a></li>
            <li style="display: none;"><a title="More pages" class="m-datatable__pager-link m-datatable__pager-link--more-prev" data-page="1"><i class="la la-ellipsis-h"></i></a></li>
            <li style="display: none;">
                <input type="text" class="m-pager-input form-control" title="Page number">
            </li>
            <li><a class="m-datatable__pager-link m-datatable__pager-link-number m-datatable__pager-link--active" data-page="1" title="1">1</a></li>
            <li><a class="m-datatable__pager-link m-datatable__pager-link-number" data-page="2" title="2">2</a></li>
            <li><a class="m-datatable__pager-link m-datatable__pager-link-number" data-page="3" title="3">3</a></li>
            <li><a class="m-datatable__pager-link m-datatable__pager-link-number" data-page="4" title="4">4</a></li>
            <li><a class="m-datatable__pager-link m-datatable__pager-link-number" data-page="5" title="5">5</a></li>
            <li><a class="m-datatable__pager-link m-datatable__pager-link-number" data-page="6" title="6">6</a></li>
            <li><a title="More pages" class="m-datatable__pager-link m-datatable__pager-link--more-next" data-page="7"><i class="la la-ellipsis-h"></i></a></li>
            <li><a title="Next" class="m-datatable__pager-link m-datatable__pager-link--next" data-page="2"><i class="la la-angle-right"></i></a></li>
            <li><a title="Last" class="m-datatable__pager-link m-datatable__pager-link--last" data-page="35"><i class="la la-angle-double-right"></i></a></li>
        </ul>
        <div class="m-datatable__pager-info">
            <div class="btn-group bootstrap-select m-datatable__pager-size" style="width: 70px;">
                <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" role="button" title="Select page size"><span class="filter-option pull-left">10</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span>
                </button>
                <div class="dropdown-menu open" role="combobox">
                    <ul class="dropdown-menu inner" role="listbox" aria-expanded="false">
                        <li data-original-index="1" class="selected"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="true"><span class="text">10</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>
                        <li data-original-index="2"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">20</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>
                        <li data-original-index="3"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">30</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>
                        <li data-original-index="4"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">50</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>
                        <li data-original-index="5"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">100</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>
                    </ul>
                </div>
                <select class="selectpicker m-datatable__pager-size" title="Select page size" data-width="70px" data-selected="10" tabindex="-98">
                    <option class="bs-title-option" value="">Select page size</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div><span class="m-datatable__pager-detail">Displaying 1 - 10 of 100 posts</span></div>
    </div>
</div>
<!--end: Datatable -->