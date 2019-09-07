<section class="section longread-text">
    <div class="container">
        @if(!empty($block->text_title))
            <h1>{{ $block->text_title }}</h1>
        @endif
        <div class="columns">
            <div class="column">
                <div class="content">
                    {!! $block->text_text !!}
                </div>
            </div>
        </div>
    </div>
</section>