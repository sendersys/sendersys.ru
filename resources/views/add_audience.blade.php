@include('dashboard.header_v2')

<?php if(!isset($user_site)): ?>
@include('dashboard.add_audience') {{-- форма добавления сайта --}}
<?php endif; ?>

</div>
@include('dashboard.footer')
