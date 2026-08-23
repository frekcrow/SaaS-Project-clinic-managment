<?php
$file = 'resources/views/doctor/dashboard.blade.php';
$content = file_get_contents($file);
$content = preg_replace('/(<\/div>\s*)+<script>/s',
    '
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script>', $content);
file_put_contents($file, $content);
