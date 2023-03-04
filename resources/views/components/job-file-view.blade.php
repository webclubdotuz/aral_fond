<div>
    <?php
    // dd($job);
    $file_extension = pathinfo($job->file_path, PATHINFO_EXTENSION);
    ?>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
        data-bs-target="#fullscreeexampleModal{{ $job->id }}">
        Fullscreen Modal
    </button>
    <div class="modal fade" id="fullscreeexampleModal{{ $job->id }}" tabindex="-1"
        aria-labelledby="fullscreeexampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fullscreeexampleModalLabel">Full Screen Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($file_extension == 'pdf')

                    <div class="text-center" style="height: 100%">
                        <embed src="{{ asset('storage/' . $job->file_path) }}" type="application/pdf" width="100%" height="600px" />
                    </div>
                    @else
                    <div class="text-center" style="height: 100%">
                        <img src="{{ asset('storage/' . $job->file_path) }}" alt="" height="100%">
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-light" data-bs-dismiss="modal"><i class="mdi mdi-close-circle-outline me-1"></i></a>
                    <button type="button" class="btn btn-primary"><i class="mdi mdi-content-save-outline me-1"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
