@if(isset($setting))
<form action="{{ route('admin.setting.store') }}" method="post" class="setting-form">
    {{ csrf_field() }}
    <div class="accordion custom-accordionwitharrow" id="settingGroupAccordion">
    	@foreach($setting as $group => $lists)
        <div class="card mb-1 shadow-none border">
            <a href="#" class="text-dark" data-toggle="collapse"
                data-target="#{{ 'setting'.$group }}" aria-expanded="true"
                aria-controls="{{ 'setting'.$group }}">
                <div class="card-header" style="background:#eee;" id="setting-title-{{ $group }}">
                    <h5 class="m-0 font-size-14">
                        {{ strtoupper($group) }} 
                        <i class="uil uil-angle-down float-right accordion-arrow"></i>
                    </h5>
                </div>
            </a>
            <div id="{{ 'setting'.$group }}" class="collapse {{ $loop->iteration == 1 ? 'show' : '' }}"
                data-parent="#settingGroupAccordion">
                <div class="card-body text-muted">
                    @foreach($lists['items'] as $item)
                	<div class="form-group">
                		<label>{{ $item->getTitle() }}</label>
                        {!! Input::type($item->getType(), $group.'['.$item->getName().']', [
                            'attr' => $item->getConfig(),
                            'value' => $item->getValue()
                        ]) !!}
                	</div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

        <div class="p-3">
            <button class="btn btn-primary btn-block">
                <i class="icon" data-feather="save"></i> {{ __('core::module.form.save_setting') }}
            </button>
        </div>

    </div>		
</form>
@endif