<div>
    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
        @csrf
        <div class="btn-group">
            <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary"><i class="mdi mdi-eye"></i></a>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i class="mdi mdi-pencil"></i></a>
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="mdi mdi-delete"></i></button>
        </div><!-- /btn-group -->
        </form>
</div>
