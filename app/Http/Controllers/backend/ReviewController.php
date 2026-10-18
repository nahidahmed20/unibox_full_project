<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['product', 'user'])->latest()->paginate(20);

        $totalReviews = Review::count();
        $approvedReviews = Review::where('status', true)->count();
        $pendingReviews = Review::where('status', false)->count();
        $averageRating = Review::avg('rating') ? number_format(Review::avg('rating'), 1) : '5.0';

        return view('backend.review.index', compact(
            'reviews',
            'totalReviews',
            'approvedReviews',
            'pendingReviews',
            'averageRating'
        ));
    }

    public function toggleStatus($id)
    {
        $review = Review::findOrFail($id);
        $review->status = !$review->status;
        $review->save();

        return response()->json([
            'success' => true,
            'status' => $review->status,
            'message' => 'Review status updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }
}

