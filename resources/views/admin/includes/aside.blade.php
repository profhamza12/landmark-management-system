<aside class="dark">
    <div class="site-name">
        <a href="" class="d-block">
            <img src="{{asset('admin/images/logo.png')}}" alt="logo" class="rounded-circle" width="40" height="40">
            <span>{{__('admin.site_name')}}</span>
        </a>
    </div>
    <div class="user-info">
        <a href="" class="d-block">
            <img src="{{asset('admin/images/logo.png')}}" alt="logo" class="rounded-circle" width="40" height="40">
            <span>{{auth()->user()->name}}</span>
        </a>
    </div>
    <ul class="items list-unstyled">
        <li>
            <a href="{{route('admin.home')}}" class="d-block bg-primary active">
                <div class="item-name">
                <i class="fa-solid fa-house-user"></i>
                    <span>{{__('admin.dashboard')}}</span>
                </div>
                <div class="item-icon">
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                        <i class="fa-solid fa-angles-left"></i>
                    @endif
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                        <i class="fa-solid fa-angles-right"></i>
                    @endif
                </div>
            </a>
        </li>
        <li class="main">
            <a href="" class="d-block toggle-ul">
                <div class="item-name">
                    <span class="main-icon"><i class="fa-regular fa-envelope"></i></span>
                    <span>{{__('admin.main_files')}}</span>
                </div>
                <div class="item-icon">
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                        <i class="fa-solid fa-angles-left"></i>
                    @endif
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                        <i class="fa-solid fa-angles-right"></i>
                    @endif
                </div>
            </a>
            <ul class="list-unstyled data">
                <li>
                <a href="" class="d-block toggle-ul">
                    <div class="item-name">
                        <i class="fa-regular fa-circle"></i>
                        <span>{{__('admin.languages')}}</span>
                    </div>
                    <div class="item-icon">
                        <span class="items-count bg-primary">6</span>
                        @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                            <i class="fa-solid fa-angles-left"></i>
                        @endif
                        @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                            <i class="fa-solid fa-angles-right"></i>
                        @endif
                    </div>
                </a>
                <ul class="list-unstyled data">
                    <li>
                        <a href="{{route('languages.index')}}" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.show_langs')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('languages.create')}}" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_lang')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="main">
                <a href="" class="d-block toggle-ul">
                    <div class="item-name">
                        <i class="fa-regular fa-circle"></i>
                        <span>{{__('admin.users')}}</span>
                    </div>
                    <div class="item-icon">
                        <span class="items-count bg-primary">6</span>
                        @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                            <i class="fa-solid fa-angles-left"></i>
                        @endif
                        @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                            <i class="fa-solid fa-angles-right"></i>
                        @endif
                    </div>
                </a>
                <ul class="list-unstyled data">
                    <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.show_users')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_user')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-block toggle-ul">
                            <div class="item-name">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.user_groups')}}</span>
                            </div>
                            <div class="item-icon">
                                @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                    <i class="fa-solid fa-angles-left"></i>
                                @endif
                                @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                    <i class="fa-solid fa-angles-right"></i>
                                @endif
                            </div>
                        </a>
                        <ul class="list-unstyled data">
                            <li>
                                <a href="" class="d-block">
                                    <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.show_groups')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="d-block">
                                    <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.add_group')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="" class="d-block toggle-ul">
                            <div class="item-name">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.permissions')}}</span>
                            </div>
                            <div class="item-icon">
                                <span class="items-count bg-primary">6</span>
                                @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                    <i class="fa-solid fa-angles-left"></i>
                                @endif
                                @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                    <i class="fa-solid fa-angles-right"></i>
                                @endif
                            </div>
                        </a>
                        <ul class="list-unstyled data">
                            <li>
                                <a href="" class="d-block">
                                    <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.show_permissions')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="d-block">
                                    <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.add_permission')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="" class="d-block toggle-ul">
                    <div class="item-name">
                        <i class="fa-regular fa-circle"></i>
                        <span>{{__('admin.company_branches')}}</span>
                    </div>
                    <div class="item-icon">
                        <span class="items-count bg-primary">6</span>
                        @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                            <i class="fa-solid fa-angles-left"></i>
                        @endif
                        @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                            <i class="fa-solid fa-angles-right"></i>
                        @endif
                    </div>
                </a>
                <ul class="list-unstyled data">
                    <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.show_branches')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_branch')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="" class="d-block toggle-ul">
                    <div class="item-name">
                        <i class="fa-regular fa-circle"></i>
                        <span>{{__('admin.coins')}}</span>
                    </div>
                    <div class="item-icon">
                        <span class="items-count bg-primary">6</span>
                        @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                            <i class="fa-solid fa-angles-left"></i>
                        @endif
                        @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                            <i class="fa-solid fa-angles-right"></i>
                        @endif
                    </div>
                </a>
                <ul class="list-unstyled data">
                    <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.show_coins')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_coin')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="" class="d-block toggle-ul">
                    <div class="item-name">
                        <i class="fa-regular fa-circle"></i>
                        <span>{{__('admin.invoice_types')}}</span>
                    </div>
                    <div class="item-icon">
                        <span class="items-count bg-primary">6</span>
                        @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                            <i class="fa-solid fa-angles-left"></i>
                        @endif
                        @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                            <i class="fa-solid fa-angles-right"></i>
                        @endif
                    </div>
                </a>
                <ul class="list-unstyled data">
                    <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.show_invoice_types')}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-block">
                        <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_invoice_type')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            </ul>
        </li>
        <li class="main">
            <a href="" class="d-block toggle-ul">
                <div class="item-name">
                <span class="main-icon"><i class="fa-solid fa-file-lines"></i></span>
                    <span>{{__('admin.human_resources')}}</span>
                </div>
                <div class="item-icon">
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                        <i class="fa-solid fa-angles-left"></i>
                    @endif
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                        <i class="fa-solid fa-angles-right"></i>
                    @endif
                </div>
            </a>
            <ul class="list-unstyled data">
                <li class="main">
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.employees')}}</span>
                        </div>
                        <div class="item-icon">
                            <span class="items-count bg-primary">6</span>
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_emps')}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.add_emp')}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="d-block toggle-ul">
                                <div class="item-name">
                                <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.employees_groups')}}</span>
                                </div>
                                <div class="item-icon">
                                    <span class="items-count bg-primary">6</span>
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                        <i class="fa-solid fa-angles-left"></i>
                                    @endif
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                        <i class="fa-solid fa-angles-right"></i>
                                    @endif
                                </div>
                            </a>
                            <ul class="list-unstyled data">
                                <li>
                                    <a href="" class="d-block">
                                    <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.show_emp_groups')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="d-block">
                                    <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.add_emp_group')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        </ul>
                    </li>
            </ul>
        </li>
        <li class="main">
            <a href="" class="d-block toggle-ul">
                <div class="item-name">
                    <span class="main-icon"><i class="fa-solid fa-database"></i></span>
                    <span>{{__('admin.stores')}}</span>
                </div>
                <div class="item-icon">
                    <span class="items-count bg-primary">6</span>
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                        <i class="fa-solid fa-angles-left"></i>
                    @endif
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                        <i class="fa-solid fa-angles-right"></i>
                    @endif
                </div>
            </a>
            <ul class="list-unstyled data">
                <li>
                    <a href="" class="d-block">
                    <i class="fa-regular fa-circle"></i>
                        <span>{{__('admin.show_stores')}}</span>
                    </a>
                </li>
                <li>
                    <a href="" class="d-block">
                    <i class="fa-regular fa-circle"></i>
                        <span>{{__('admin.add_store')}}</span>
                    </a>
                </li>
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                        <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.units')}}</span>
                        </div>
                        <div class="item-icon">
                            <span class="items-count bg-primary">6</span>
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_units')}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.add_unit')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                        <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.main_categories')}}</span>
                        </div>
                        <div class="item-icon">
                            <span class="items-count bg-primary">6</span>
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_categories')}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.add_category')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                        <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.items')}}</span>
                        </div>
                        <div class="item-icon">
                            <span class="items-count bg-primary">6</span>
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_items')}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.add_item')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.transfer_quantity')}}</span>
                        </div>
                        <div class="item-icon">
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_all_transfer')}}</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="d-block">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.add_transfer')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="main">
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.treasury_bonds')}}</span>
                        </div>
                        <div class="item-icon">
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block toggle-ul">
                                <div class="item-name">
                                    <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.receivable_entries')}}</span>
                                </div>
                                <div class="item-icon">
                                    <span class="items-count bg-primary">6</span>
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                        <i class="fa-solid fa-angles-left"></i>
                                    @endif
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                        <i class="fa-solid fa-angles-right"></i>
                                    @endif
                                </div>
                            </a>
                            <ul class="list-unstyled data">
                                <li>
                                    <a href="" class="d-block">
                                        <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.show_all_receipt')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="d-block">
                                        <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.add_receipt')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="" class="d-block toggle-ul">
                                <div class="item-name">
                                    <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.payable_entries')}}</span>
                                </div>
                                <div class="item-icon">
                                    <span class="items-count bg-primary">6</span>
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                        <i class="fa-solid fa-angles-left"></i>
                                    @endif
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                        <i class="fa-solid fa-angles-right"></i>
                                    @endif
                                </div>
                            </a>
                            <ul class="list-unstyled data">
                                <li>
                                    <a href="" class="d-block">
                                        <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.show_all_payable')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="d-block">
                                        <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.add_payable')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="" class="d-block toggle-ul">
                                <div class="item-name">
                                    <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.inventory_entries')}}</span>
                                </div>
                                <div class="item-icon">
                                    <span class="items-count bg-primary">6</span>
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                        <i class="fa-solid fa-angles-left"></i>
                                    @endif
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                        <i class="fa-solid fa-angles-right"></i>
                                    @endif
                                </div>
                            </a>
                            <ul class="list-unstyled data">
                                <li>
                                    <a href="" class="d-block">
                                        <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.show_all_inventory')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="d-block">
                                        <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.add_inventory')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="" class="d-block toggle-ul">
                                <div class="item-name">
                                    <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.out_stock')}}</span>
                                </div>
                                <div class="item-icon">
                                    <span class="items-count bg-primary">6</span>
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                        <i class="fa-solid fa-angles-left"></i>
                                    @endif
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                        <i class="fa-solid fa-angles-right"></i>
                                    @endif
                                </div>
                            </a>
                            <ul class="list-unstyled data">
                                <li>
                                    <a href="" class="d-block">
                                        <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.show_out_stocks')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="" class="d-block toggle-ul">
                                <div class="item-name">
                                    <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.perishables')}}</span>
                                </div>
                                <div class="item-icon">
                                    <span class="items-count bg-primary">6</span>
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                        <i class="fa-solid fa-angles-left"></i>
                                    @endif
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                        <i class="fa-solid fa-angles-right"></i>
                                    @endif
                                </div>
                            </a>
                            <ul class="list-unstyled data">
                                <li>
                                    <a href="" class="d-block">
                                        <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.show_all_perishables')}}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="" class="d-block">
                                        <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.add_perishable')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="main">
            <a href="" class="d-block toggle-ul">
                <div class="item-name">
                    <span class="main-icon"><i class="fa-solid fa-bookmark"></i></span>
                    <span>{{__('admin.sales')}}</span>
                </div>
                <div class="item-icon">
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                        <i class="fa-solid fa-angles-left"></i>
                    @endif
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                        <i class="fa-solid fa-angles-right"></i>
                    @endif
                </div>
            </a>
            <ul class="list-unstyled data">
                <li class="main">
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.clients')}}</span>
                        </div>
                        <div class="item-icon">
                            <span class="items-count bg-primary">6</span>
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_clients')}}</span>
                            </a>
                        </li>
                        <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_client')}}</span>
                        </a>
                        </li>
                        <li>
                            <a href="" class="d-block toggle-ul">
                                <div class="item-name">
                                    <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.client_groups')}}</span>
                                </div>
                                <div class="item-icon">
                                    <span class="items-count bg-primary">6</span>
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                        <i class="fa-solid fa-angles-left"></i>
                                    @endif
                                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                        <i class="fa-solid fa-angles-right"></i>
                                    @endif
                                </div>
                            </a>
                            <ul class="list-unstyled data">
                                <li>
                                    <a href="" class="d-block">
                                        <i class="fa-regular fa-circle"></i>
                                        <span>{{__('admin.show_client_groups')}}</span>
                                    </a>
                                </li>
                                <li>
                                <a href="" class="d-block">
                                    <i class="fa-regular fa-circle"></i>
                                    <span>{{__('admin.add_client_group')}}</span>
                                </a>
                            </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.sales_invoices')}}</span>
                        </div>
                        <div class="item-icon">
                            <span class="items-count bg-primary">6</span>
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_sales_invoices')}}</span>
                            </a>
                        </li>
                        <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_sales_invoice')}}</span>
                        </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.prices_offers')}}</span>
                        </div>
                        <div class="item-icon">
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_prices_offers')}}</span>
                            </a>
                        </li>
                        <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_prices_offer')}}</span>
                        </a>
                    </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="main">
            <a href="" class="d-block toggle-ul">
                <div class="item-name">
                <span class="main-icon"><i class="fa-solid fa-bookmark"></i></span>
                    <span>{{__('admin.purchases')}}</span>
                </div>
                <div class="item-icon">
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                        <i class="fa-solid fa-angles-left"></i>
                    @endif
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                        <i class="fa-solid fa-angles-right"></i>
                    @endif
                </div>
            </a>
            <ul class="list-unstyled data">
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.vendors')}}</span>
                        </div>
                        <div class="item-icon">
                            <span class="items-count bg-primary">6</span>
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_vendors')}}</span>
                            </a>
                        </li>
                        <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_vendor')}}</span>
                        </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.purchases_invoices')}}</span>
                        </div>
                        <div class="item-icon">
                            <span class="items-count bg-primary">6</span>
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_purchases_invoices')}}</span>
                            </a>
                        </li>
                        <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_purchases_invoice')}}</span>
                        </a>
                    </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="main">
            <a href="" class="d-block toggle-ul">
                <div class="item-name">
                    <span class="main-icon"><i class="fa-solid fa-right-left"></i></span>
                    <span>{{__('admin.returns_sales')}}</span>
                </div>
                <div class="item-icon">
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                        <i class="fa-solid fa-angles-left"></i>
                    @endif
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                        <i class="fa-solid fa-angles-right"></i>
                    @endif
                </div>
            </a>
            <ul class="list-unstyled data">
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.return_sales_invoices')}}</span>
                        </div>
                        <div class="item-icon">
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_sales_invoices')}}</span>
                            </a>
                        </li>
                        <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_sales_invoice')}}</span>
                        </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.return_purchases_invoices')}}</span>
                        </div>
                        <div class="item-icon">
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_purchases_invoices')}}</span>
                            </a>
                        </li>
                        <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_purchases_invoice')}}</span>
                        </a>
                    </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="main">
            <a href="" class="d-block toggle-ul">
                <div class="item-name">
                    <span class="main-icon"><i class="fa-solid fa-receipt"></i></span>
                    <span>{{__('admin.accounts')}}</span>
                </div>
                <div class="item-icon">
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                        <i class="fa-solid fa-angles-left"></i>
                    @endif
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                        <i class="fa-solid fa-angles-right"></i>
                    @endif
                </div>
            </a>
            <ul class="list-unstyled data">
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.payment_vouchers')}}</span>
                        </div>
                        <div class="item-icon">
                            <span class="items-count bg-primary">6</span>
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_payment_vouchers')}}</span>
                            </a>
                        </li>
                        <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_payment_vouchers')}}</span>
                        </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="" class="d-block toggle-ul">
                        <div class="item-name">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.receipt_vouchers')}}</span>
                        </div>
                        <div class="item-icon">
                            <span class="items-count bg-primary">6</span>
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                                <i class="fa-solid fa-angles-left"></i>
                            @endif
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                                <i class="fa-solid fa-angles-right"></i>
                            @endif
                        </div>
                    </a>
                    <ul class="list-unstyled data">
                        <li>
                            <a href="" class="d-block">
                                <i class="fa-regular fa-circle"></i>
                                <span>{{__('admin.show_receipt_vouchers')}}</span>
                            </a>
                        </li>
                        <li>
                        <a href="" class="d-block">
                            <i class="fa-regular fa-circle"></i>
                            <span>{{__('admin.add_receipt_vouchers')}}</span>
                        </a>
                    </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="main">
            <a href="" class="d-block toggle-ul">
                <div class="item-name">
                <span class="main-icon"><i class="fa-solid fa-gear"></i></span>
                    <span>{{__('admin.settings')}}</span>
                </div>
                <div class="item-icon">
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                        <i class="fa-solid fa-angles-left"></i>
                    @endif
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                        <i class="fa-solid fa-angles-right"></i>
                    @endif
                </div>
            </a>
        </li>
        <li class="main">
            <a href="" class="d-block toggle-ul">
                <div class="item-name">
                    <span class="main-icon"><i class="fa-solid fa-flag"></i></span>
                    <span>{{__('admin.reports')}}</span>
                </div>
                <div class="item-icon">
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                        <i class="fa-solid fa-angles-left"></i>
                    @endif
                    @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "ar")
                        <i class="fa-solid fa-angles-right"></i>
                    @endif
                </div>
            </a>
        </li>
    </ul>
</aside>