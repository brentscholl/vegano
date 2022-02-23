<div class="box-modal modal fade" id="boxModal" tabindex="-1" role="dialog" aria-labelledby="boxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <transition name="fade" mode="out-in">
            <div key="replacing" v-if="meal_id != null" class="box-modal-header">
                <h2 class="h1">Replace a meal in your box with this meal</h2>
                <div class="meal-replace-container">
                    <div class="meal-slot hvr-bob" data-toggle="tooltip" data-placement="top" title="This meal is confirmed">
                        <img :src="meal_img" :alt="meal_title">
                        <h4>@{{ meal_title }}</h4>
                    </div>
                </div>
                <button type="button" class="btn btn-close" data-dismiss="modal"><i class="fas fa-times"></i></button>
            </div>
            <div key="title" v-else class="box-modal-header">
                <h2 class="h1">My Boxes</h2>
                <button type="button" class="btn btn-close" data-dismiss="modal"><i class="fas fa-times"></i></button>
            </div>
        </transition>

        <div v-for="box in boxes">
            <div v-if="box.status == 'ordered' || box.status == 'completed'" class="modal-content box-modal-content box-confirmed">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box-info-container">
                                    <h3>Meals for @{{ box.start_date | moment("add", "2 day", "MMM D, YYYY") }}</h3>
                                    <div class="box-details-container" v-if="box.status == 'ordered'">
                                        <div v-if="box.order_statys == 'shipped'" class="box-detail">
                                            <i class="fas fa-truck"></i>
                                            <span>Order Shipped</span>
                                        </div>
                                        <div class="box-detail" v-if="box.order_statys != 'shipped'">
                                            <i class="fas fa-calendar-check"></i>
                                            <span>Order Confirmed<br><small>(We are preparing your order)</small></span>
                                        </div>
                                        <div class="box-detail" v-if="box.order_statys != 'shipped'">
                                            <i class="fas fa-box"></i>
                                            <span>Your box will be shipped<br>@{{ box.start_date | moment("add", "1 day", "from", "now") }}</span>
                                        </div>
                                    </div>
                                    <div class="box-details-container" v-else-if="box.status == 'completed'">
                                        <div class="box-detail">
                                            <i class="fas fa-calendar-check"></i>
                                            <span>Order Completed<br></span>
                                        </div>
                                        <div class="box-detail">
                                            <i class="fas fa-home"></i>
                                            <span>Your box has been delivered</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="meal-slot-container">
                                    <div v-for="item in box.box_items" class="meal-slot" data-toggle="tooltip" data-placement="top" title="This meal is confirmed">
                                        <div class="slot-icon"><i class="fas fa-check"></i></div>
                                        <div class="meal-link-container">
                                            <img :src="item.itemable.image.src + item.itemable.image.filename" :alt="item.itemable.title">
                                            <h4>@{{ item.itemable.title }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else-if="box.status == 'skipped'" class="modal-content box-modal-content box-skipped">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box-info-container">
                                    <h3>Meals for @{{ box.start_date | moment("add", "2 day", "MMM D, YYYY") }} <span>(Skipped)</span></h3>
                                    <div class="box-details-container">
                                        <div class="box-detail">
                                            <i class="fas fa-calendar-times"></i>
                                            <span>Order Skipped</span>
                                        </div>
                                        <button v-if="skippableDate(box.start_date)" type="button" class="btn btn-skip unskip" @click="unSkipBox(box.id)">
                                            <i class="fas fa-calendar-check"></i>
                                            <span>Unskip This box</span>
                                        </button>
                                        <div v-else class="box-detail">
                                            <span>Passed unskipping period</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="meal-slot-container">
                                    <div class="meal-slot">
                                        <div class="slot-icon"><i class="fas fa-ban"></i></div>
                                    </div>
                                    <div class="meal-slot">
                                        <div class="slot-icon"><i class="fas fa-ban"></i></div>
                                    </div>
                                    <div class="meal-slot">
                                        <div class="slot-icon"><i class="fas fa-ban"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="modal-content box-modal-content box-open">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box-info-container">
                                    <h3>Meals for @{{ box.start_date | moment("add", "2 day", "MMM D, YYYY") }}</h3>
                                    <div class="box-details-container">
                                        <div class="box-detail">
                                            <i class="fas fa-box-open"></i>
                                            <span>You have @{{ box.start_date | moment("subtract", "1 week", "add", "4 days", "from", "now", true) }}<br>until this box is ordered</span>
                                        </div>
                                        <button type="button" class="btn btn-skip" @click="skipBox(box.id)">
                                            <i class="fas fa-calendar-times"></i>
                                            <span>Skip This Box</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div v-if="meal_id != null" class="meal-slot-container">
                                    <button v-for="item in box.box_items" class="btn meal-slot meal-is-replaceable" v-bind:class="{ isReplacing: isReplacing  }" @click="replaceMeal(meal_id, item.id)"
                                        data-toggle="tooltip" data-placement="top" title="Replace this meal">
                                        <div class="slot-icon"><i class="fas fa-sync-alt"></i></div>
                                        <div class="meal-link-container">
                                            <img :src="item.itemable.image.src + item.itemable.image.filename" :alt="item.itemable.title">
                                            <h4>@{{ item.itemable.title }}</h4>
                                        </div>
                                    </button>
                                </div>
                                <div v-else class="meal-slot-container">
                                    <div v-for="item in box.box_items" class="meal-slot" >
                                        <a href="{{ route('meals.index') }}" data-toggle="tooltip" data-placement="left" title="Replace this meal"
                                            class="slot-icon"><i class="fas fa-sync-alt"></i></a>
                                        <a class="meal-link-container" :href="'/meals/' + item.itemable.slug" data-toggle="tooltip" data-placement="top" title="View this meal">
                                            <img :src="item.itemable.image.src + item.itemable.image.filename" :alt="item.itemable.title">
                                            <h4>@{{ item.itemable.title }}</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end v-for="box in boxes" -->
    </div>
    <transition>
        <div class="box-loading" v-show="boxLoading">
            <div class="fa-3x">
                <i class="fas fa-circle-notch fa-spin"></i>
            </div>
        </div>
    </transition>
</div>
@section('scripts.vue-variables')
    <script>
        var boxes = {!! json_encode($boxes) !!};
    </script>
@stop



