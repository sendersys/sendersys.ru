<?php

use App\Models\Segment;
use App\Models\Users_site;

$current_domen_name = null;
$second_site = null;
$segments = null;
$domen_id = null;

// dd($segment);

if(isset($second_site_code)) $second_site = $second_site_code;
// if(isset($segment)) $segments = $segment;


foreach ($current_domen as $domen_name) {
	$current_domen_name = $domen_name->domen;
	$domen_id = $domen_name->id;
}

$segments = Segment::where('domen_id', '=', $domen_id)->get();
$domen_confirm = Users_site::where('id', '=', $domen_id)->first();
$confirm_hash = $domen_confirm->confirm_hash;
$confirm_status = $domen_confirm->confirm;

// dd($current_domen);
if($current_domen_name == null && $second_site == null): ?>
@include('dashboard.header')
@include('dashboard.add_site') {{-- форма добавления сайта --}}
</div>
@include('dashboard.footer')
<?php endif; ?>

<?php if($current_domen_name !== null && $second_site == null && count($segments) == 0 && $confirm_status == 0): ?> {{-- если домен не подтвержден --}}
@include('dashboard.header_v2')
@include('dashboard.audience_confirm') {{-- форма если сайт уже есть --}}
</div>
@include('dashboard.footer')
<?php endif; ?>

<?php if($current_domen_name !== null && $second_site == null && count($segments) == 0 && $confirm_status == 1): ?> {{-- и нет аудитории --}}
@include('dashboard.header_v2')
@include('dashboard.audience') {{-- форма если сайт уже есть --}}
</div>
@include('dashboard.footer')
<?php endif; ?>

<?php if($current_domen_name !== null && $second_site == null && count($segments) > 0): ?> {{-- и eсть аудитория --}}
@include('dashboard.header_v2')
@include('dashboard.audience_segment') {{-- форма если сайт уже есть --}}
</div>
@include('dashboard.footer')
<?php endif; ?>

<?php if($second_site !== null): ?> 
@include('dashboard.header_v2')
@include('dashboard.add_site') {{-- форма если сайт уже есть --}}
</div>
@include('dashboard.footer')
<?php endif; ?>