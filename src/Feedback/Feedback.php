<?php

namespace Kcfbricks\PhpBricklinkSdk\Feedback;

use DateTime;
use Kcfbricks\PhpBricklinkSdk\ApiObject;

class Feedback extends ApiObject {
	/**
	 * An identification of the feedback
	 */
	protected int $feedbackId;

	/**
	 * The ID of the order associated with the feedback
	 */
	protected int $orderId;

	/**
	 * The username of who posts this feedback
	 */
	protected string $from;

	/**
	 * The username of who receives this feedback
	 */
	protected string $to;

	/**
	 * The time the feedback was posted
	 */
	protected DateTime $dateRated;

	/**
	 * The rating for a transaction (scale 0 to 2) 	0: Praise, 1: Neutral, 2: Complaint
	 */
	protected Rating $rating;

	/**
	 * Indicates whether the feedback is written for a seller or a buyer 	S: Seller, B: Buyer
	 */
	protected RatingOfBs $ratingOfBs;

	/**
	 * A comment associated with the feedback
	 */
	protected string $comment;

	/**
	 * A reply for this feedback
	 */
	protected string $reply;

	public function getFeedbackId(): int {
		return $this->feedbackId;
	}

	public function setFeedbackId(int $feedbackId): self {
		$this->feedbackId = $feedbackId;

		return $this;
	}

	public function getOrderId(): int {
		return $this->orderId;
	}

	public function setOrderId(int $orderId): self {
		$this->orderId = $orderId;

		return $this;
	}

	public function getFrom(): string {
		return $this->from;
	}

	public function setFrom(string $from): self {
		$this->from = $from;

		return $this;
	}

	public function getTo(): String {
		return $this->to;
	}

	public function setTo(String $to): self {
		$this->to = $to;

		return $this;
	}

	public function getDateRated(): DateTime {
		return $this->dateRated;
	}

	public function setDateRated(DateTime $dateRated): self {
		$this->dateRated = $dateRated;

		return $this;
	}

	public function getRating(): Rating {
		return $this->rating;
	}

	public function setRating(Rating $rating): self {
		$this->rating = $rating;

		return $this;
	}

	public function getRatingOfBs(): RatingOfBs {
		return $this->ratingOfBs;
	}

	public function setRatingOfBs(RatingOfBs $ratingOfBs): self {
		$this->ratingOfBs = $ratingOfBs;

		return $this;
	}

	public function getComment(): string {
		return $this->comment;
	}

	public function setComment(string $comment): self {
		$this->comment = $comment;

		return $this;
	}

	public function getReply(): string {
		return $this->reply;
	}

	public function setReply(string $reply): self {
		$this->reply = $reply;

		return $this;
	}
}
