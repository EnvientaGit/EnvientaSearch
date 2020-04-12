<div id="profile-modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ENVIENTA Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="profileForm">
                <div class="modal-body">
                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Basic Info</a></li>
                            <li><a href="#tabs-2">Location</a></li>
                            <li><a href="#tabs-3">Social Links</a></li>
                            <li><a href="#tabs-4">Keywords</a></li>
                            <li><a href="#tabs-5">Crypto Addresses</a></li>
                        </ul>
                        <div id="tabs-1">
                            <div class="form-group">
                                <label for="profileName">Display Name</label>
                                <input type="text" class="form-control" id="profileName">
                            </div>
                            <div class="form-group">
                                <label for="profileFirstName">First Name</label>
                                <input type="text" class="form-control" id="profileFirstName">
                            </div>
                            <div class="form-group">
                                <label for="profileLastName">Last Name</label>
                                <input type="text" class="form-control" id="profileLastName">
                            </div>
                            <div class="form-group">
                                <label for="profileEmail">Email</label>
                                <input type="text" class="form-control" id="profileEmail">
                            </div>

                            <div class="form-group">
                                <label for="profileDescription">About Me</label>
                                <textarea class="form-control" id="profileDescription" rows="6"></textarea>
                            </div>
                        </div>
                        <div id="tabs-2">
                            <div class="form-group">
                                <label for="profileAddress">Your location</label>
                                <input type="text" class="form-control" id="profileAddress" aria-describedby="profileAddressHelp">
                                <small id="profileAddressHelp" class="form-text text-muted">Start typing your address, then press ENTER to position the marker on the map. You can refine it by moving the marker.</strong></small>
                                <div id="profile-map-canvas" class="map_canvas"></div>
                            </div>
                        </div>
                        <div id="tabs-3">
                            <div class="form-group">
                                <select class="form-control" id="profileLink">
                                    <option value="1">Website</option>
                                    <option value="2">LinkedIn</option>
                                    <option value="3">Twitter</option>
                                    <option value="4">Facebook</option>
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
                                Keywords<br />
                                <small>You have to set at least one keyword if you want to be searchable in our local search engine.</small>
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
                                <label for="profileENV">ENV Wallet Address</label>
                                <input type="text" class="form-control" id="profileENV">

                            </div>
                            <div class="form-group">
                                <label for="profileBTC">BTC Wallet Address</label>
                                <input type="text" class="form-control" id="profileBTC">

                            </div>
                            <div class="form-group">
                                <label for="profileETH">ETH Wallet Address</label>
                                <input type="text" class="form-control" id="profileETH">

                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button id="profileSaveButton" type="submit" class="btn btn-primary">Save</button>
                    </div>
            </form>
        </div>
    </div>
</div>