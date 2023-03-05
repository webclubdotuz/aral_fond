<div>
    <?php
    // dd($job);
    $file_extension = pathinfo($job->file_path, PATHINFO_EXTENSION);
    ?>

    @if ($file_extension == 'pdf' || $file_extension == 'PDF')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#fullscreeexampleModal{{ $job->id }}">
            <i class="uil-file-alt"></i>
        </button>
    @else
        <button type="button" class="btn btn-primary p-0" data-bs-toggle="modal"
            data-bs-target="#fullscreeexampleModal{{ $job->id }}">
            <img src="{{ asset('storage/' . $job->file_path) }}" alt="" height="34px" class="p-0">
        </button>
    @endif

    <div class="modal fade" id="fullscreeexampleModal{{ $job->id }}" tabindex="-1"
        aria-labelledby="fullscreeexampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fullscreeexampleModalLabel">№{{ $job->id }}</h5>
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
                    <div class="row">
                        <div class="col-12">
                            @if (hasRole('expert-photo') || hasRole('export-text'))
                                <form action="{{ route('jobs.ball', $job->id) }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    <div class="input-group mb-3">
                                        <input type="number" name="ball" id="ball" class="form-control" placeholder="Балл" required min="0" max="100" step="any" value="{{ $job->ball }}">
                                        @if($job->ball_date == now()->format('Y-m-d') || $job->ball_date == null)
                                            <button type="submit" class="btn btn-primary"><i class="uil-check"></i></button>
                                        @endif
                                        {{-- <button type="submit" class="btn btn-primary"><i class="uil-check"></i></button> --}}
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
