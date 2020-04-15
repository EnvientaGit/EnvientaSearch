<div id="profile-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ENVIENTA <span data-localize="profile">Profile</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="profileForm">
                <div class="modal-body">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1"><span data-localize="basicinfo">Basic Info</span></a></li>
                            <li><a href="#tabs-2"><span data-localize="location">Location</span></a></li>
                            <li><a href="#tabs-3"><span data-localize="sociallinks">Social Links</span></a></li>
                            <li><a href="#tabs-4"><span data-localize="keywords">Keywords</span></a></li>
                            <li><a href="#tabs-5"><span data-localize="cryptoaddresses">Crypto Addresses</span></a></li>
                        </ul>
                        <div id="tabs-1">
                            <div class="form-group">
                                <label for="profileName"><span data-localize="profilename">Display Name</span></label>
                                <input type="text" class="form-control" id="profileName">
                            </div>
                            <div class="form-group">
                                <label for="profileFirstName"><span data-localize="firstname">First Name</span></label>
                                <input type="text" class="form-control" id="profileFirstName">
                            </div>
                            <div class="form-group">
                                <label for="profileLastName"><span data-localize="lastname">Last Name</span></label>
                                <input type="text" class="form-control" id="profileLastName">
                            </div>
                            <div class="form-group">
                                <label for="profileEmail"><span data-localize="email">Email</span></label>
                                <input type="text" class="form-control" id="profileEmail">
                            </div>

                            <div class="form-group">
                                <label for="profileDescription"><span data-localize="aboutme">About Me</span></label>
                                <textarea class="form-control" id="profileDescription" rows="6"></textarea>
                            </div>
                        </div>
                        <div id="tabs-2">
                            <div class="form-group">
                                <label for="profileAddress"><span data-localize="location">Location</span></label>
                                <input type="text" class="form-control" id="profileAddress" aria-describedby="profileAddressHelp">
                                <small id="profileAddressHelp" class="form-text text-muted"><strong><span data-localize="typeaddress">Start typing your address, then press ENTER to position the marker on the map. You can refine it by moving the marker.Your address will be not public.</span></strong></small>
                                <div id="profile-map-canvas" class="map_canvas"></div>
                            </div>
                        </div>
                        <div id="tabs-3">
                            <div class="form-group">
                                <select class="form-control" id="profileLink">
                                    <option value="1"><span data-localize="website">Website</span></option>
                                    <option value="2">Facebook</option>
                                    <option value="3">Twitter</option>
                                    <option value="4">LinkedIn</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="profileURL" placeholder="URL">
                            </div>
                            <input type="button" class="add-row" value="Add Link">
                            <table id="tblLinks">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Link Name</th>
                                        <th>URL</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <input type="button" class="delete-row" value="Remove Link">

                        </div>
                        <div id="tabs-4">
                            <div class="form-group">
                                <span data-localize="keywords">Keywords</span><br />
                                <small><span data-localize="setupkeywords">You have to set at least one keyword if you want to be searchable in our local search engine.</span></small>
                            </div>
                            <?php foreach ($resource_types as $idx => $resource_type) : ?>
                                <div class="form-group">
                                    <!--
                                    <label for="profile-<?= $resource_type->key ?>"><?= $resource_type->title ?></label>
                                    -->
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="profile-<?= $resource_type->key ?>-search-input" placeholder="Start typing a keyword" autocomplete="off">
                                    </div>
                                    <div style="height: 1rem;"></div>
                                    <span id="profile-<?= $resource_type->key ?>-taglist-active"></span>
                                    <span id="profile-<?= $resource_type->key ?>-taglist"></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div id="tabs-5">
                            <div class="form-group">
                                <label for="profileENV">ENV <span data-localize="walletaddress">Wallet Address</span></label>
                                <input type="text" class="form-control" id="profileENV">

                            </div>
                            <div class="form-group">
                                <label for="profileBTC">BTC <span data-localize="walletaddress">Wallet Address</span></label>
                                <input type="text" class="form-control" id="profileBTC">

                            </div>
                            <div class="form-group">
                                <label for="profileETH">ETH <span data-localize="walletaddress">Wallet Address</span></label>
                                <input type="text" class="form-control" id="profileETH">

                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><span data-localize="cancel">Cancel</span></button>
                        <button id="profileSaveButton" type="submit" class="btn btn-primary"><span data-localize="save">Save</span></button>
                    </div>
            </form>
        </div>
    </div>
</div>