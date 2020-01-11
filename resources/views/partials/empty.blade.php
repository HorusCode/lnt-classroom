<div class="empty-data">
    <div class="empty-data__image">
        <span class="mdi mdi-card-search-outline"></span>
    </div>
    <div class="empty-data__content">
        <p class="text-title text-muted">Active course not found!</p>
        <div class="d-flex justify-content-center">
            <button class="btn btn-primary rounded" @click="showCreateCourse = true">
                <span class="mdi mdi-plus"></span>
                New Course
            </button>
        </div>
    </div>
</div>
<create-course v-if="showCreateCourse" anim="scaleUp" @close="showCreateCourse = false"></create-course>
