<div class="card" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input type="text" class="form-control" v-model="thread.title">
        </div>

    </div>
    <div class="card-body form-group">
        <textarea name="" id="" rows="4" v-model="thread.body" class="form-control"></textarea>
    </div>

    @can('update',$thread)
        <div class="card-footer level">
            <div>
                <div @click="onEdit" class="btn-sm btn btn-primary">Update</div>
                <div @click="editing=false" class="btn-sm btn btn-outline-secondary">Cancel</div>
            </div>
            <div class="ml-auto">
                @can('delete',$thread)
                    <form method="POST" action="{{ $thread->path()}}">
                        @csrf  @method('DELETE')
                        <button type="submit" class="btn btn-link text-nowrap"> Delete Thread </button>
                    </form>
                @endcan
            </div>
        </div>
    @endcan
</div>



<div class="card" v-else>
    <div class="card-header">
        <div class="level">

            <img src="{{ $thread->creator->avatar()}}" alt="" width="50" height="50" class="mr-2 rounded-lg">
            <span class="flex">
                    <a href="{{  $thread->creator->path() }}">
                        {{ $thread->creator->name }}
                    </a>
                    posted
                    <span v-text="thread.title">
                    </span>

            </span>
        </div>

    </div>
    <div class="card-body" v-text="thread.body">
    </div>
    @can('update',$thread)
        <div class="card-footer">
            <div @click="editing=true" class="btn-sm btn btn-outline-secondary">Edit</div>
        </div>
    @endcan
</div>
