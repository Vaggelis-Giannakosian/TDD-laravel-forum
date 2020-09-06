<div class="card" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input type="text" class="form-control" v-model="form.title">
        </div>

    </div>
    <div class="card-body form-group">
        <wysiwyg v-model="form.body"  name="body"></wysiwyg>
    </div>


        <div class="card-footer level">
            <div>
                <div @click="onUpdate" class="btn-sm btn btn-primary">Update</div>
                <div @click="resetForm" class="btn-sm btn btn-outline-secondary">Cancel</div>
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
                    <span v-text="title">
                    </span>

            </span>
        </div>

    </div>
    <div class="card-body" v-html="body">
    </div>
        <div class="card-footer" v-if="authorize('owns',thread)">
            <div @click="editing=true" class="btn-sm btn btn-outline-secondary">Edit</div>
        </div>
</div>
