<?php

use App\Models\Segment;

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


// dd($current_domen);
if($current_domen_name == null && $second_site == null): ?>
@include('dashboard.header')
@include('dashboard.add_site') {{-- форма добавления сайта --}}
</div>
@include('dashboard.footer')
<?php endif; ?>

<?php if($current_domen_name !== null && $second_site == null && count($segments) == 0): ?> {{-- и нет аудитории --}}
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