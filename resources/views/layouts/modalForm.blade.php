<div id="{{ $id_modal }}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark modal-style">
                <h5 class="modal-title">{{ $title_modal }}</h5>
                <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-dark modal-style">
                <form id="{{ $id_modal_form }}" action="{{ $action_modal_form }}"
                    method="{{ $method_modal_form }}">
                    @csrf
                    <div class="row">
                        @foreach ($inputs_modal_form as $input)
                            <div class="col-md-12" style="flex-flow: column;">
                                <div class="col-md-5">
                                <label for="{{ $input->id }}">{{ $input->label }}</label>
                                </div>
                                <div class="col-md-12">
                                <input class="modal-input" type="{{ $input->type }}" id="{{ $input->id }}" name="{{ $input->name }}">
                                </div>
                            </div>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <div class="button-modal col-md-12 row" style="justify-content: center;">
                            <button type="submit" class="btn btn-primary"
                                form="{{ $id_modal_form }}">{{ $text_modal_button }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-dark modal-style">
                <p>@GBLTech produção</p>
            </div>
        </div>
    </div>
</div>

{{-- @include('layouts.modalForm', [
    'id_modal'=>'modal_id',
    'title_modal'=>'Titulo do modal',
    'id_modal_form'=>'form_id',
    'method_modal_form'=>'POST',
    'action_modal_form'=>'action_modal',
    'inputs_modal_form'=>[
        (object)[
            'label'=>'label',
            'id'=>'id',
            'name'=>'name',
            'type'=>'type'
        ],
        (object)[
            'label'=>'label',
            'id'=>'id',
            'name'=>'name',
            'type'=>'type'
        ]
    ],
    'text_modal_button'=>'Texto do botão',
]) --}}
